<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pesanan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman utama laporan
     */
    public function index()
    {
        $userRole = auth()->user() ? auth()->user()->role : 'admin';
        
        $data = [
            'total_transaksi' => Transaksi::count(),
            'total_pesanan' => Pesanan::count(),
        ];

        switch ($userRole) {
            case 'owner':
                $data['total_penghasilan'] = Transaksi::sum('total');
                $data['penghasilan_hari_ini'] = Transaksi::whereDate('created_at', Carbon::today())->sum('total');
                $data['penghasilan_bulan_ini'] = Transaksi::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total');
                break;
                
            case 'kasir':
                $data['transaksi_hari_ini'] = Transaksi::whereDate('created_at', Carbon::today())->count();
                $data['total_penghasilan_hari_ini'] = Transaksi::whereDate('created_at', Carbon::today())->sum('total');
                break;
                
            case 'waiter':
                $data['pesanan_belum_bayar'] = Pesanan::whereDoesntHave('transaksi')->count();
                $data['pesanan_hari_ini'] = Pesanan::whereDate('created_at', Carbon::today())->count();
                break;
        }

        return view('laporan.index', compact('data'));
    }

    /**
     * Laporan Transaksi
     */
    public function transaksi(Request $request)
    {
        $query = Transaksi::with(['pesanan.detailPesanans.menu', 'pesanan.pelanggan']);
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transaksis = $query->get();
        $total = $transaksis->sum('total');

        return view('laporan.transaksi', compact('transaksis', 'total'));
    }

    /**
     * Laporan Pesanan
     */
    public function pesanan(Request $request)
    {
        $query = Pesanan::with(['detailPesanans.menu', 'pelanggan', 'transaksi']);
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $pesanans = $query->get();
        $total_pesanan = $pesanans->count();
        $total_belum_bayar = $pesanans->filter(function($pesanan) {
            return !$pesanan->transaksi;
        })->count();

        return view('laporan.pesanan', compact('pesanans', 'total_pesanan', 'total_belum_bayar'));
    }

    /**
     * Export laporan ke PDF
     */
    public function export($type, Request $request)
    {
        switch ($type) {
            case 'transaksi':
                $query = Transaksi::with(['pesanan.detailPesanans.menu', 'pesanan.pelanggan']);
                
                if ($request->filled('start_date')) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }
                
                if ($request->filled('end_date')) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }

                $transaksis = $query->get();
                $total = $transaksis->sum('total');
                
                $pdf = Pdf::loadView('laporan.pdf.transaksi', compact('transaksis', 'total'));
                $pdf->setPaper('A4', 'landscape');
                return $pdf->download('laporan_transaksi_' . date('Y-m-d') . '.pdf');
                break;
                
            case 'pesanan':
                $query = Pesanan::with(['detailPesanans.menu', 'pelanggan', 'transaksi']);
                
                if ($request->filled('start_date')) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }
                
                if ($request->filled('end_date')) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }

                $pesanans = $query->get();
                
                $pdf = Pdf::loadView('laporan.pdf.pesanan', compact('pesanans'));
                $pdf->setPaper('A4', 'landscape');
                return $pdf->download('laporan_pesanan_' . date('Y-m-d') . '.pdf');
                break;
                
            default:
                abort(404);
        }
    }

    /**
     * Print laporan untuk kasir (stream langsung)
     */
    public function printReport($type, Request $request)
    {
        switch ($type) {
            case 'transaksi':
                $query = Transaksi::with(['pesanan.detailPesanans.menu', 'pesanan.pelanggan']);
                
                if ($request->filled('start_date')) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }
                
                if ($request->filled('end_date')) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }

                $transaksis = $query->get();
                $total = $transaksis->sum('total');
                
                $pdf = Pdf::loadView('laporan.pdf.transaksi', compact('transaksis', 'total'));
                $pdf->setPaper('A4', 'landscape');
                return $pdf->stream('laporan_transaksi_' . date('Y-m-d') . '.pdf');
                break;
                
            case 'pesanan':
                $query = Pesanan::with(['detailPesanans.menu', 'pelanggan', 'transaksi']);
                
                if ($request->filled('start_date')) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }
                
                if ($request->filled('end_date')) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }

                $pesanans = $query->get();
                
                $pdf = Pdf::loadView('laporan.pdf.pesanan', compact('pesanans'));
                $pdf->setPaper('A4', 'landscape');
                return $pdf->stream('laporan_pesanan_' . date('Y-m-d') . '.pdf');
                break;
                
            default:
                abort(404);
        }
    }
}
