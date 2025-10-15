@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tambah Pelanggan Baru</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('pelanggans.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="namapelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control @error('namapelanggan') is-invalid @enderror" 
                                   id="namapelanggan" name="namapelanggan" value="{{ old('namapelanggan') }}" required>
                            @error('namapelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('jeniskelamin') is-invalid @enderror" 
                                    id="jeniskelamin" name="jeniskelamin" required>
                                <option value="1" {{ old('jeniskelamin', '1') == '1' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="0" {{ old('jeniskelamin') == '0' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jeniskelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nohp" class="form-label">No. HP</label>
                            <input type="text" class="form-control @error('nohp') is-invalid @enderror" 
                                   id="nohp" name="nohp" value="{{ old('nohp') }}" required>
                            @error('nohp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
