@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Meja #{{ $meja->nomor_meja }}</h4>
                    <a href="{{ route('mejas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('mejas.update', $meja) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nomor_meja" class="form-label">Nomor Meja</label>
                            <input type="text" class="form-control" id="nomor_meja" name="nomor_meja" 
                                   value="{{ old('nomor_meja', $meja->nomor_meja) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="kapasitas" name="kapasitas" 
                                   value="{{ old('kapasitas', $meja->kapasitas) }}" min="1" max="20" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="tersedia" {{ old('status', $meja->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="terisi" {{ old('status', $meja->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="reserved" {{ old('status', $meja->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $meja->keterangan) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
