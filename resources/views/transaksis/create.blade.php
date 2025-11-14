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
                                            data-pelanggan="{{ $pesanan->pelanggan->namapelanggan }}"
                                            data-items="{{ json_encode($pesanan->detailPesanans->map(function($dp) { return ['menu' => $dp->menu->namamenu, 'jumlah' => $dp->jumlah, 'harga' => $dp->menu->harga, 'subtotal' => $dp->subtotal]; })) }}"
                                            {{ old('idpesanan') == $pesanan->idpesanan ? 'selected' : '' }}>
                                        {{ $pesanan->pelanggan->namapelanggan }} - {{ $pesanan->detailPesanans->count() }} item(s) - Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}
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
                                    <p class="mb-2"><strong>Pelanggan:</strong> <span id="detail-pelanggan"></span></p>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Menu</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th class="text-end">Harga Satuan</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail-items">
                                                <!-- Items will be populated here -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-end">Total:</th>
                                                    <th class="text-end" id="detail-total">Rp 0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
    const detailItems = document.getElementById('detail-items');
    const detailTotal = document.getElementById('detail-total');

    function updatePesananDetail() {
        const selectedOption = pesananSelect.options[pesananSelect.selectedIndex];
        
        if (selectedOption.value) {
            // Tampilkan detail pesanan
            pesananDetail.style.display = 'block';
            
            // Update pelanggan
            detailPelanggan.textContent = selectedOption.dataset.pelanggan;
            
            // Parse items
            const items = JSON.parse(selectedOption.dataset.items || '[]');
            let total = 0;
            
            // Clear existing items
            detailItems.innerHTML = '';
            
            // Add items to table
            items.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.menu}</td>
                    <td class="text-center">${item.jumlah}x</td>
                    <td class="text-end">Rp ${formatNumber(item.harga)}</td>
                    <td class="text-end">Rp ${formatNumber(item.subtotal)}</td>
                `;
                detailItems.appendChild(row);
                total += item.subtotal;
            });
            
            // Update total
            detailTotal.textContent = 'Rp ' + formatNumber(total);
            
            // Update total harga input
            totalInput.value = total;
            
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
