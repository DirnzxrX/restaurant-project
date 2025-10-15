@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data Pesanan</h4>
                    <a href="{{ route('pesanans.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pesanan
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Menu</th>
                                    <th>Pelanggan</th>
                                    <th>Jumlah</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Kasir/Waiter</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesanans as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->idpesanan }}</td>
                                    <td>{{ $pesanan->menu->namamenu }}</td>
                                    <td>{{ $pesanan->pelanggan->namapelanggan }}</td>
                                    <td>{{ $pesanan->jumlah }}</td>
                                    <td>Rp {{ number_format($pesanan->jumlah * $pesanan->menu->harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($pesanan->transaksis->count() > 0)
                                            <span class="badge bg-success">Sudah Lunas</span>
                                        @else
                                            <span class="badge bg-warning">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>{{ $pesanan->user->name }}</td>
                                    <td>{{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pesanans.show', $pesanan) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pesanans.edit', $pesanan) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pesanans.destroy', $pesanan) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pesanans->isEmpty())
                        <div class="text-center py-4">
                            <h5 class="text-muted">Belum ada data pesanan</h5>
                            <p class="text-muted">Klik tombol "Tambah Pesanan" untuk menambah pesanan pertama.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
