@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Meja</h4>
                    <a href="{{ route('mejas.create') }}" class="btn btn-primary btn-sm">Tambah Meja</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No Meja</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mejas as $meja)
                            <tr>
                                <td>{{ $meja->nomor_meja }}</td>
                                <td>{{ $meja->kapasitas }} orang</td>
                                <td>
                                    @if($meja->status == 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($meja->status == 'terisi')
                                        <span class="badge bg-danger">Terisi</span>
                                    @else
                                        <span class="badge bg-warning">Reserved</span>
                                    @endif
                                </td>
                                <td>{{ $meja->keterangan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('mejas.edit', $meja) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('mejas.destroy', $meja) }}" 
                                          style="display: inline;" onsubmit="return confirm('Hapus meja ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($mejas->isEmpty())
                        <div class="text-center py-4">
                            <p>Belum ada data meja</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
