@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tambah Pesanan Baru</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('pesanans.store') }}" method="POST" id="pesananForm">
                        @csrf

                        <div class="mb-3">
                            <label for="idpelanggan" class="form-label">Pilih Pelanggan <span class="text-danger">*</span></label>
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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><strong>Item Pesanan</strong></label>
                                <button type="button" class="btn btn-sm btn-success" onclick="addItem()">
                                    <i class="fas fa-plus"></i> Tambah Item
                                </button>
                            </div>
                            <div id="items-container">
                                <!-- Items will be added here dynamically -->
                            </div>
                            @error('items')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="alert alert-info">
                                <label class="form-label mb-0"><strong>Total Harga:</strong></label>
                                <div id="total-harga" class="fs-5 text-primary">Rp 0</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('pesanans.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let itemCount = 0;
const menus = @json($menus);

function addItem() {
    itemCount++;
    const container = document.getElementById('items-container');
    const itemDiv = document.createElement('div');
    itemDiv.className = 'card mb-2 item-row';
    itemDiv.id = `item-${itemCount}`;
    
    itemDiv.innerHTML = `
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Menu</label>
                    <select class="form-select item-menu" name="items[${itemCount}][idmenu]" required onchange="updateItemTotal(${itemCount})">
                        <option value="">-- Pilih Menu --</option>
                        ${menus.map(menu => `
                            <option value="${menu.idmenu}" data-harga="${menu.harga}">
                                ${menu.namamenu} - Rp ${parseInt(menu.harga).toLocaleString('id-ID')}
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control item-jumlah" name="items[${itemCount}][jumlah]" 
                           value="1" min="1" required onchange="updateItemTotal(${itemCount}); calculateGrandTotal()">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control item-subtotal" readonly value="Rp 0">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${itemCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(itemDiv);
    updateItemTotal(itemCount);
    calculateGrandTotal();
}

function removeItem(id) {
    const item = document.getElementById(`item-${id}`);
    if (item) {
        item.remove();
        calculateGrandTotal();
    }
}

function updateItemTotal(id) {
    const item = document.getElementById(`item-${id}`);
    if (!item) return;
    
    const menuSelect = item.querySelector('.item-menu');
    const jumlahInput = item.querySelector('.item-jumlah');
    const subtotalInput = item.querySelector('.item-subtotal');
    
    if (menuSelect.value && jumlahInput.value) {
        const harga = parseInt(menuSelect.selectedOptions[0].getAttribute('data-harga'));
        const jumlah = parseInt(jumlahInput.value);
        const subtotal = harga * jumlah;
        subtotalInput.value = 'Rp ' + subtotal.toLocaleString('id-ID');
    } else {
        subtotalInput.value = 'Rp 0';
    }
    
    calculateGrandTotal();
}

function calculateGrandTotal() {
    const items = document.querySelectorAll('.item-row');
    let total = 0;
    
    items.forEach(item => {
        const subtotalText = item.querySelector('.item-subtotal').value;
        const subtotal = parseInt(subtotalText.replace(/[^\d]/g, '')) || 0;
        total += subtotal;
    });
    
    document.getElementById('total-harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Add first item on page load
document.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>
@endsection
