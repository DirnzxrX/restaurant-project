<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\Pelanggan;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $userRole = $user->role;

    // Data umum untuk semua role
    $data = [
        'total_menu' => Menu::count(),
        'total_pelanggan' => Pelanggan::count(),
        'pesanan_hari_ini' => Pesanan::whereDate('created_at', Carbon::today())->count(),
        'total_transaksi' => Transaksi::count(),
    ];

    switch ($userRole) {
        case 'kasir':
            $data['transaksi_hari_ini'] = Transaksi::whereDate('created_at', Carbon::today())->count();
            $data['total_penghasilan_hari'] = Transaksi::whereDate('created_at', Carbon::today())->sum('total');
            break;

        case 'waiter':
        case 'admin':
            $data['pesanan_belum_bayar'] = Pesanan::whereDoesntHave('transaksis')->count();
            $data['pesanan_belum_selesai'] = Pesanan::whereDoesntHave('transaksis')->count();
            break;

        case 'owner':
            $data['total_penghasilan'] = Transaksi::sum('total');
            $data['penghasilan_hari'] = Transaksi::whereDate('created_at', Carbon::today())->sum('total');
            $data['penghasilan_bulan'] = Transaksi::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)->sum('total');
            break;
    }

    return view('dashboard', compact('data', 'userRole'));
    }
}
