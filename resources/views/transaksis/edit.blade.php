@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Transaksi #{{ $transaksi->idtransaksi }}</h4>
                    <div>
                        <a href="{{ route('transaksis.show', $transaksi) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Info Transaksi Saat Ini -->
                    <div class="card bg-light mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Transaksi Saat Ini</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Pesanan:</strong><br>
                                    {{ $transaksi->pesanan->pelanggan->namapelanggan }} - {{ $transaksi->pesanan->menu->namamenu }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Total:</strong><br>
                                    <span class="badge bg-info">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Bayar:</strong><br>
                                    <span class="badge bg-primary">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('transaksis.update', $transaksi) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="idpesanan" class="form-label">Pilih Pesanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('idpesanan') is-invalid @enderror" id="idpesanan" name="idpesanan" required>
                                <option value="">-- Pilih Pesanan --</option>
                                @foreach($pesanans as $pesanan)
                                    <option value="{{ $pesanan->idpesanan }}" 
                                            {{ (old('idpesanan', $transaksi->idpesanan) == $pesanan->idpesanan) ? 'selected' : '' }}>
                                        {{ $pesanan->pelanggan->namapelanggan }} - {{ $pesanan->menu->namamenu }} ({{ $pesanan->jumlah }}x)
                                    </option>
                                @endforeach
                            </select>
                            @error('idpesanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('total') is-invalid @enderror" 
                                       id="total" name="total" value="{{ old('total', $transaksi->total) }}" 
                                       min="0" required>
                            </div>
                            @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bayar" class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('bayar') is-invalid @enderror" 
                                       id="bayar" name="bayar" value="{{ old('bayar', $transaksi->bayar) }}" 
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
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Perbarui Transaksi
                            </button>
                        </div>
                    </form>

                    <!-- Delete Button -->
                    <hr>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="button" class="btn btn-danger" 
                                onclick="confirmDelete({{ $transaksi->idtransaksi }}, '{{ $transaksi->pesanan->pelanggan->namapelanggan }}')">
                            <i class="fas fa-trash"></i> Hapus Transaksi
                        </button>
                    </div>

                    <!-- Hidden form for deletion -->
                    <form id="delete-form" method="POST" 
                          action="{{ route('transaksis.destroy', $transaksi) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalInput = document.getElementById('total');
    const bayarInput = document.getElementById('bayar');
    const kembalianInput = document.getElementById('kembalian');

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

    // Calculate initial value
    calculateKembalian();

    totalInput.addEventListener('input', calculateKembalian);
    bayarInput.addEventListener('input', calculateKembalian);
});

function confirmDelete(transaksiId, pelangganName) {
    if (confirm(`Apakah Anda yakin ingin menghapus transaksi ${transaksiId} untuk ${pelangganName}?`)) {
        document.getElementById('delete-form').submit();
    }
}
</script>

@endsection
