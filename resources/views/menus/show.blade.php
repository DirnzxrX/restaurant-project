@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Menu</h4>
                    <a href="{{ route('menus.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">ID Menu:</label>
                        <p>{{ $menu->idmenu }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Menu:</label>
                        <p>{{ $menu->namamenu }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga:</label>
                        <p>Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('menus.edit', $menu->idmenu) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('menus.destroy', $menu->idmenu) }}" method="POST" 
                              class="d-inline" onsubmit="return confirm('Hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
