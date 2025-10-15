@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Menu</h4>
                    <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm">Tambah Menu</a>
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
                                <th>ID</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ $menu->idmenu }}</td>
                                <td>{{ $menu->namamenu }}</td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('menus.edit', $menu->idmenu) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('menus.destroy', $menu->idmenu) }}" method="POST" 
                                        class="d-inline" onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($menus->isEmpty())
                        <div class="text-center py-4">
                            <p>Belum ada data menu</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

