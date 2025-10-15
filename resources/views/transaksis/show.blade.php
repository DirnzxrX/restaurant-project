@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Transaksi #{{ $transaksi->idtransaksi }}</h4>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Transaksi -->
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Informasi Transaksi</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>ID Transaksi:</strong></td>
                                            <td>{{ $transaksi->idtransaksi }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal:</strong></td>
                                            <td>{{ $transaksi->created_at->format('d F Y, H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Harga:</strong></td>
                                            <td><span class="badge bg-info fs-6">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jumlah Bayar:</strong></td>
                                            <td><span class="badge bg-primary fs-6">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kembalian:</strong></td>
                                            @php
                                                $kembalian = $transaksi->bayar - $transaksi->total;
                                            @endphp
                                            <td><span class="badge bg-success fs-6">Rp {{ number_format($kembalian, 0, ',', '.') }}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pesanan -->
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Informasi Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>ID Pesanan:</strong></td>
                                            <td>{{ $transaksi->idpesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Menu:</strong></td>
                                            <td>{{ $transaksi->pesanan->menu->namamenu }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pelanggan:</strong></td>
                                            <td>{{ $transaksi->pesanan->pelanggan->namapelanggan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jumlah:</strong></td>
                                            <td>{{ $transaksi->pesanan->jumlah }} porsi</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Harga Satuan:</strong></td>
                                            <td>Rp {{ number_format($transaksi->pesanan->menu->harga, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pelanggan -->
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Detail Pelanggan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Nama:</strong><br>
                                    {{ $transaksi->pesanan->pelanggan->namapelanggan }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Telepon:</strong><br>
                                    {{ $transaksi->pesanan->pelanggan->telepon }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Alamat:</strong><br>
                                    {{ $transaksi->pesanan->pelanggan->alamat }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Menu -->
                    <div class="card bg-light">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-utensils"></i> Detail Menu</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Nama Menu:</strong><br>
                                    {{ $transaksi->pesanan->menu->namamenu }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Harga Menu:</strong><br>
                                    Rp {{ number_format($transaksi->pesanan->menu->harga, 0, ',', '.') }} / porsi
                                </div>
                            </div>
                            @if($transaksi->pesanan->menu->deskripsi)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <strong>Deskripsi:</strong><br>
                                    {{ $transaksi->pesanan->menu->deskripsi }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('transaksis.edit', $transaksi) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Transaksi
                        </a>
                        <form method="POST" action="{{ route('transaksis.destroy', $transaksi) }}" 
                              style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus Transaksi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
