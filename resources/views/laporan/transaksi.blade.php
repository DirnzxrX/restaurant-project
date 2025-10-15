@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Laporan Transaksi</h5>
        </div>
        <div class="card-body">

            {{-- Filter Tanggal --}}
            <form method="GET" action="{{ route('laporan.transaksi') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('laporan.export', ['type' => 'transaksi', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                       class="btn btn-danger me-2" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Download PDF
                    </a>
                    <a href="{{ route('laporan.print', ['type' => 'transaksi', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                       class="btn btn-warning" target="_blank">
                        <i class="fas fa-print me-1"></i>Cetak Langsung
                    </a>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $trx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $trx->pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $trx->status == 'lunas' ? 'success' : 'warning' }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 text-end">
                <h5><strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
