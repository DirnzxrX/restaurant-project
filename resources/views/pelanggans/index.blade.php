@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data Pelanggan</h4>
                    <a href="{{ route('pelanggans.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pelanggan
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
                                    <th>ID</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelanggans as $pelanggan)
                                <tr>
                                    <td>{{ $pelanggan->idpelanggan }}</td>
                                    <td>{{ $pelanggan->namapelanggan }}</td>
                                    <td>{{ $pelanggan->jeniskelamin ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $pelanggan->nohp }}</td>
                                    <td>{{ Str::limit($pelanggan->alamat, 30) }}</td>
                                    <td>{{ $pelanggan->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pelanggans.show', $pelanggan) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pelanggans.edit', $pelanggan) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pelanggans.destroy', $pelanggan) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
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

                    @if($pelanggans->isEmpty())
                        <div class="text-center py-4">
                            <h5 class="text-muted">Belum ada data pelanggan</h5>
                            <p class="text-muted">Klik tombol "Tambah Pelanggan" untuk menambah data pertama.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
