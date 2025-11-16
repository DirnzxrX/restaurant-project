@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Pelanggan</h4>
                    <div>
                        <a href="{{ route('pelanggans.edit', $pelanggan) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>ID Pelanggan:</strong></div>
                        <div class="col-sm-9">{{ $pelanggan->idpelanggan }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Nama Pelanggan:</strong></div>
                        <div class="col-sm-9">{{ $pelanggan->namapelanggan }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Jenis Kelamin:</strong></div>
                        <div class="col-sm-9">{{ $pelanggan->jeniskelamin ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>No. HP:</strong></div>
                        <div class="col-sm-9">{{ $pelanggan->nohp }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Alamat:</strong></div>
                        <div class="col-sm-9">{{ $pelanggan->alamat }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-3"><strong>Tanggal Dibuat:</strong></div>
                        <div class="col-sm-9">{{ $pelanggan->created_at->format('d F Y, H:i') }}</div>
                    </div>

                    <div>

                    @if($pelanggan->pesanans->count() > 0)
                        <hr>
                        <h5>Riwayat Pesanan</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Rincian Pesanan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelanggan->pesanans as $pesanan)
                                    <tr>
                                        <td>{{ $pesanan->idpesanan }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($pesanan->detailPesanans as $i)
                                                    <li>{{ $i->menu->namamenu }}({{ $i->jumlah }})</li>                                                    
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <hr>
                        <p class="text-muted">Pelanggan ini belum memiliki riwayat pesanan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
