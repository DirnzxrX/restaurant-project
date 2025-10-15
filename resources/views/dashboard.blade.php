@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <p>Selamat datang, {{ Auth::user()->namauser }}!</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total_menu'] }}</h3>
                    <p>Total Menu</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total_pelanggan'] }}</h3>
                    <p>Total Pelanggan</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['pesanan_hari_ini'] }}</h3>
                    <p>Pesanan Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['total_transaksi'] }}</h3>
                    <p>Total Transaksi</p>
                </div>
            </div>
        </div>
    </div>

    @if($userRole == 'kasir')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>{{ $data['transaksi_hari_ini'] ?? 0 }}</h3>
                    <p>Transaksi Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3>Rp {{ number_format($data['total_penghasilan_hari'] ?? 0, 0, ',', '.') }}</h3>
                    <p>Pendapatan Hari Ini</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <p>Tanggal: {{ date('d F Y') }}</p>
                    <p>Waktu: {{ date('H:i') }}</p>
                    <p>Role: {{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
