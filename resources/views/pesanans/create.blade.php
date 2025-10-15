@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tambah Pesanan Baru</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('pesanans.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="idmenu" class="form-label">Pilih Menu</label>
                            <select class="form-select @error('idmenu') is-invalid @enderror" 
                                    id="idmenu" name="idmenu" required>
                                <option value="">-- Pilih Menu --</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->idmenu }}" 
                                            data-harga="{{ $menu->harga }}"
                                            {{ old('idmenu') == $menu->idmenu ? 'selected' : '' }}>
                                        {{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idmenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idpelanggan" class="form-label">Pilih Pelanggan</label>
                            <select class="form-select @error('idpelanggan') is-invalid @enderror" 
                                    id="idpelanggan" name="idpelanggan" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->idpelanggan }}" 
                                            {{ old('idpelanggan') == $pelanggan->idpelanggan ? 'selected' : '' }}>
                                        {{ $pelanggan->namapelanggan }} - {{ $pelanggan->nohp }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idpelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                   id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                                   min="1" required onchange="calculateTotal()">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="alert alert-info">
                                <label class="form-label"><strong>Total Harga:</strong></label>
                                <div id="total-harga" class="fs-5 text-primary">Rp 0</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="iduser" class="form-label">Penanggung Jawab</label>
                            <select class="form-select @error('iduser') is-invalid @enderror" 
                                    id="iduser" name="iduser" required>
                                <option value="">-- Pilih User --</option>
                                <option value="{{ auth()->user()->id }}" selected>
                                    {{ auth()->user()->namauser ?? auth()->user()->name }}
                                </option>
                            </select>
                            @error('iduser')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('pesanans.index') }}" class="btn btn-secondary me-md-2">
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

<script>
function calculateTotal() {
    const menuSelect = document.getElementById('idmenu');
    const jumlahInput = document.getElementById('jumlah');
    const totalElement = document.getElementById('total-harga');
    
    if (menuSelect.value && jumlahInput.value) {
        const harga = parseInt(menuSelect.selectedOptions[0].getAttribute('data-harga'));
        const jumlah = parseInt(jumlahInput.value);
        const total = harga * jumlah;
        totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
    } else {
        totalElement.textContent = 'Rp 0';
    }
}

// Event listeners
document.getElementById('idmenu').addEventListener('change', calculateTotal);
document.getElementById('jumlah').addEventListener('input', calculateTotal);
</script>
@endsection
