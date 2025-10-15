@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Pesanan</h4>
                    <div>
                        @if($pesanan->transaksis->count() == 0 && (auth()->user()->role == 'kasir' || auth()->user()->role == 'admin'))
                            <a href="{{ route('transaksis.create', ['pesanan_id' => $pesanan->idpesanan]) }}" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-cash-register"></i> Proses Pembayaran
                            </a>
                        @endif
                        <a href="{{ route('pesanans.edit', $pesanan) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('pesanans.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>ID Pesanan:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->idpesanan }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Menu:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->menu->namamenu }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Harga per Item:</strong></div>
                        <div class="col-sm-9">Rp {{ number_format($pesanan->menu->harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Pelanggan:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->pelanggan->namapelanggan }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>No. HP Pelanggan:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->pelanggan->nohp }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Jumlah:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->jumlah }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Total Harga:</strong></div>
                        <div class="col-sm-9 fs-5 text-primary">Rp {{ number_format($pesanan->jumlah * $pesanan->menu->harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Status:</strong></div>
                        <div class="col-sm-9">
                            @if($pesanan->transaksis->count() > 0)
                                <span class="badge bg-success fs-6">Sudah Lunas</span>
                            @else
                                <span class="badge bg-warning fs-6">Belum Bayar</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Penanggung Jawab:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->user->name }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Tanggal Dibuat:</strong></div>
                        <div class="col-sm-9">{{ $pesanan->created_at->format('d F Y, H:i') }}</div>
                    </div>

                    @if($pesanan->transaksis->count() > 0)
                        <hr>
                        <h5>Data Transaksi</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID Transaksi</th>
                                        <th>Total</th>
                                        <th>Bayar</th>
                                        <th>Kembalian</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan->transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->idtransaksi }}</td>
                                        <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</td>
                                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
