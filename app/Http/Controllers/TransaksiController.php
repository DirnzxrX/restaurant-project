<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Transaksi::with(['pesanan.detailPesanans.menu', 'pesanan.pelanggan']);
        
        // Filter by date if provided
        if (request('tanggal')) {
            $query->whereDate('created_at', request('tanggal'));
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        
        return view('transaksis.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pesanans = Pesanan::whereDoesntHave('transaksi')->with(['detailPesanans.menu', 'pelanggan'])->orderBy('created_at', 'desc')->get();
        return view('transaksis.create', compact('pesanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpesanan' => 'required|exists:pesanans,idpesanan',
            'total' => 'required|integer|min:0',
            'bayar' => 'required|integer|min:0',
        ]);

        // Ambil data pesanan untuk validasi total
        $pesanan = Pesanan::with('detailPesanans.menu')->findOrFail($request->idpesanan);
        $calculatedTotal = $pesanan->subtotal;

        // Validasi apakah total yang dikirim sama dengan total yang dihitung
        if ($request->total != $calculatedTotal) {
            return back()->with('error', 'Total harga tidak sesuai dengan pesanan. Silakan refresh halaman dan coba lagi.');
        }

        // Pastikan bayar >= total
        if ($request->bayar < $request->total) {
            return back()->with('error', 'Jumlah bayar tidak boleh kurang dari total.');
        }

        // Tambahkan status default
        $data = $request->all();
        $data['status'] = 'lunas';

        $transaksi = Transaksi::create($data);

        return redirect()->route('transaksis.create')
            ->with('success', 'Transaksi berhasil ditambahkan.')
            ->with('last_transaksi_id', $transaksi->idtransaksi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pesanan.detailPesanans.menu', 'pesanan.pelanggan']);
        return view('transaksis.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $pesanans = Pesanan::with(['detailPesanans.menu', 'pelanggan'])->orderBy('created_at', 'desc')->get();
        $transaksi->load(['pesanan.detailPesanans.menu', 'pesanan.pelanggan']);
        return view('transaksis.edit', compact('transaksi', 'pesanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'idpesanan' => 'required|exists:pesanans,idpesanan',
            'total' => 'required|integer|min:0',
            'bayar' => 'required|integer|min:0',
        ]);

        if ($request->bayar < $request->total) {
            return back()->with('error', 'Jumlah bayar tidak boleh kurang dari total.');
        }

        $transaksi->update($request->all());

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Print receipt for transaction
     */
    public function printReceipt(Transaksi $transaksi)
    {
        $transaksi->load(['pesanan.detailPesanans.menu', 'pesanan.pelanggan', 'pesanan.user']);
        
        $pdf = Pdf::loadView('receipt.pdf', compact('transaksi'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('struk_transaksi_' . $transaksi->idtransaksi . '.pdf');
    }
}