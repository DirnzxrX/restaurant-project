@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Menu</h4>
                    <a href="{{ route('menus.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('menus.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="namamenu" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="namamenu" name="namamenu" 
                                   value="{{ old('namamenu') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" 
                                   value="{{ old('harga') }}" required min="0">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

