@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Tambah Transaksi</h4>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transaksis.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="idpesanan" class="form-label">Pilih Pesanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('idpesanan') is-invalid @enderror" id="idpesanan" name="idpesanan" required>
                                <option value="">-- Pilih Pesanan --</option>
                                @foreach($pesanans as $pesanan)
                                    <option value="{{ $pesanan->idpesanan }}" 
                                            data-subtotal="{{ $pesanan->subtotal }}"
                                            data-menu="{{ $pesanan->menu->namamenu }}"
                                            data-pelanggan="{{ $pesanan->pelanggan->namapelanggan }}"
                                            data-jumlah="{{ $pesanan->jumlah }}"
                                            data-harga="{{ $pesanan->menu->harga }}"
                                            {{ old('idpesanan') == $pesanan->idpesanan ? 'selected' : '' }}>
                                        {{ $pesanan->pelanggan->namapelanggan }} - {{ $pesanan->menu->namamenu }} ({{ $pesanan->jumlah }}x) - Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idpesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Detail Pesanan -->
                        <div class="mb-3" id="pesanan-detail" style="display: none;">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Detail Pesanan</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Pelanggan:</strong> <span id="detail-pelanggan"></span></p>
                                            <p class="mb-1"><strong>Menu:</strong> <span id="detail-menu"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Jumlah:</strong> <span id="detail-jumlah"></span></p>
                                            <p class="mb-1"><strong>Harga Satuan:</strong> Rp <span id="detail-harga"></span></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="mb-0"><strong>Total Harga:</strong> Rp <span id="detail-total"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('total') is-invalid @enderror" 
                                       id="total" name="total" value="{{ old('total') }}" 
                                       min="0" required readonly>
                            </div>
                            @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Total harga akan dihitung otomatis dari pesanan yang dipilih.</div>
                        </div>

                        <div class="mb-3">
                            <label for="bayar" class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('bayar') is-invalid @enderror" 
                                       id="bayar" name="bayar" value="{{ old('bayar') }}" 
                                       min="0" required>
                            </div>
                            @error('bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Jumlah bayar harus lebih besar atau sama dengan total harga.</div>
                        </div>

                        <div class="mb-3">
                            <label for="kembalian" class="form-label">Kembalian</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="kembalian" readonly>
                            </div>
                            <div class="form-text">Kembalian akan dihitung otomatis.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                    
                    <!-- Success Message dengan tombol cetak struk -->
                    @if(session('success') && session('last_transaksi_id'))
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <div class="mt-2">
                                <a href="{{ route('transaksis.receipt', session('last_transaksi_id')) }}" 
                                   class="btn btn-success btn-sm" target="_blank">
                                    <i class="fas fa-print me-1"></i>Cetak Struk
                                </a>
                                <a href="{{ route('transaksis.index') }}" class="btn btn-secondary btn-sm ms-2">
                                    <i class="fas fa-list me-1"></i>Lihat Semua Transaksi
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pesananSelect = document.getElementById('idpesanan');
    const totalInput = document.getElementById('total');
    const bayarInput = document.getElementById('bayar');
    const kembalianInput = document.getElementById('kembalian');
    const pesananDetail = document.getElementById('pesanan-detail');

    // Elements untuk detail pesanan
    const detailPelanggan = document.getElementById('detail-pelanggan');
    const detailMenu = document.getElementById('detail-menu');
    const detailJumlah = document.getElementById('detail-jumlah');
    const detailHarga = document.getElementById('detail-harga');
    const detailTotal = document.getElementById('detail-total');

    function updatePesananDetail() {
        const selectedOption = pesananSelect.options[pesananSelect.selectedIndex];
        
        if (selectedOption.value) {
            // Tampilkan detail pesanan
            pesananDetail.style.display = 'block';
            
            // Update detail
            detailPelanggan.textContent = selectedOption.dataset.pelanggan;
            detailMenu.textContent = selectedOption.dataset.menu;
            detailJumlah.textContent = selectedOption.dataset.jumlah;
            detailHarga.textContent = formatNumber(selectedOption.dataset.harga);
            detailTotal.textContent = formatNumber(selectedOption.dataset.subtotal);
            
            // Update total harga
            totalInput.value = selectedOption.dataset.subtotal;
            
            // Hitung kembalian
            calculateKembalian();
        } else {
            // Sembunyikan detail pesanan
            pesananDetail.style.display = 'none';
            totalInput.value = '';
            kembalianInput.value = '';
        }
    }

    function calculateKembalian() {
        const total = parseFloat(totalInput.value) || 0;
        const bayar = parseFloat(bayarInput.value) || 0;
        const kembalian = Math.max(0, bayar - total);
        
        kembalianInput.value = kembalian;
        
        // Ubah warna berdasarkan status
        if (bayar >= total) {
            kembalianInput.classList.remove('text-danger');
            kembalianInput.classList.add('text-success');
        } else {
            kembalianInput.classList.remove('text-success');
            kembalianInput.classList.add('text-danger');
        }
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Event listeners
    pesananSelect.addEventListener('change', updatePesananDetail);
    bayarInput.addEventListener('input', calculateKembalian);

    // Initialize jika ada old value
    if (pesananSelect.value) {
        updatePesananDetail();
    }
});
</script>

@endsection
