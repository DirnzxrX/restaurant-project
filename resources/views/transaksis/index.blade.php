@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data Transaksi</h4>
                    <a href="{{ route('transaksis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Transaksi
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('transaksis.index') }}">
                                <div class="input-group">
                                    <input type="date" name="tanggal" class="form-control" 
                                           value="{{ request('tanggal') }}" placeholder="Filter tanggal">
                                    <button type="submit" class="btn btn-outline-secondary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    @if(request('tanggal'))
                                    <a href="{{ route('transaksis.index') }}" class="btn btn-outline-danger">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                @if($transaksis->count() > 0)
                                    <span class="badge bg-info">
                                        Total {{ $transaksis->count() }} transaksi
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>ID Pesanan</th>
                                    <th>Items</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->idtransaksi }}</td>
                                    <td>{{ $transaksi->idpesanan }}</td>
                                    <td>
                                        @if($transaksi->pesanan->detailPesanans->count() > 0)
                                            <ul class="mb-0" style="padding-left: 20px;">
                                                @foreach($transaksi->pesanan->detailPesanans as $detail)
                                                    <li>{{ $detail->menu->namamenu }} ({{ $detail->jumlah }}x)</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">Tidak ada item</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaksi->pesanan->pelanggan->namapelanggan }}</td>
                                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</td>
                                    <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('transaksis.show', $transaksi) }}" class="btn btn-info btn-sm" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('transaksis.receipt', $transaksi) }}" class="btn btn-success btn-sm" 
                                               title="Cetak Struk" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="{{ route('transaksis.edit', $transaksi) }}" class="btn btn-warning btn-sm"
                                               title="Edit Transaksi">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    title="Hapus Transaksi"
                                                    onclick="confirmDelete('{{ $transaksi->idtransaksi }}', '{{ $transaksi->pesanan->pelanggan->namapelanggan }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Hidden form for deletion -->
                                        <form id="delete-form-{{ $transaksi->idtransaksi }}" method="POST" 
                                              action="{{ route('transaksis.destroy', $transaksi) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($transaksis->isEmpty())
                        <div class="text-center py-4">
                            <h5 class="text-muted">Belum ada data transaksi</h5>
                            <p class="text-muted">Klik tombol "Tambah Transaksi" untuk membuat transaksi pertama.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function confirmDelete(transaksiId, pelangganName) {
    if (confirm(`Apakah Anda yakin ingin menghapus transaksi ${transaksiId} untuk ${pelangganName}?`)) {
        document.getElementById('delete-form-' + transaksiId).submit();
    }
}
</script>
