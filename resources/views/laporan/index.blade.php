@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Dashboard Laporan</h5>
    </div>
    <div class="card-body">
        <div class="row text-center">
            @if (isset($data['total_transaksi']))
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6>Total Transaksi</h6>
                        <h3>{{ $data['total_transaksi'] }}</h3>
                    </div>
                </div>
            </div>
            @endif

            @if (isset($data['total_pesanan']))
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6>Total Pesanan</h6>
                            <h3>{{ $data['total_pesanan'] }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($data['total_penghasilan']))
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6>Total Penghasilan</h6>
                            <h3>{{ $data['total_penghasilan'] }}</h3>
                        </div>
                    </div>
                </div>
            @endif
        </div>
         <div class="text-center mt-3">
                <a href="{{ route('laporan.transaksi') }}" class="btn btn-success me-2">
                    <i class="fas fa-receipt me-1"></i>Laporan Transaksi
                </a>
                <a href="{{ route('laporan.pesanan') }}" class="btn btn-primary">
                    <i class="fas fa-utensils me-1"></i>Laporan Pesanan
                </a>
            </div>
    </div>
</div>
@endsection
