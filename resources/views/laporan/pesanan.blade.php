@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Laporan Pesanan</h5>
        </div>
        <div class="card-body">

            {{-- Filter --}}
            <form method="GET" action="{{ route('laporan.pesanan') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('laporan.export', ['type' => 'pesanan', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                       class="btn btn-danger me-2" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Download PDF
                    </a>
                    <a href="{{ route('laporan.print', ['type' => 'pesanan', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                       class="btn btn-warning" target="_blank">
                        <i class="fas fa-print me-1"></i>Cetak Langsung
                    </a>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Items</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanans as $psn)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($psn->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $psn->pelanggan->namapelanggan ?? '-' }}</td>
                            <td>
                                @if($psn->detailPesanans->count() > 0)
                                    <ul class="mb-0" style="padding-left: 20px;">
                                        @foreach($psn->detailPesanans as $detail)
                                            <li>{{ $detail->menu->namamenu ?? '-' }} ({{ $detail->jumlah }}x) - Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Tidak ada item</span>
                                @endif
                            </td>
                            <td class="text-end">Rp {{ number_format($psn->subtotal, 0, ',', '.') }}</td>
                            <td>
                                @if($psn->transaksi)
                                    <span class="badge bg-success">Sudah Bayar</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 text-end">
                <p>Total Pesanan: <strong>{{ $total_pesanan }}</strong></p>
                <p>Belum Bayar: <strong>{{ $total_belum_bayar }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
