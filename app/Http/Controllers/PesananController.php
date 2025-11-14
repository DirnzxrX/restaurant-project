<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\DetailPesanan;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['detailPesanans.menu', 'pelanggan', 'user'])->get();
        return view('pesanans.index', compact('pesanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        return view('pesanans.create', compact('menus', 'pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
            'items' => 'required|array|min:1',
            'items.*.idmenu' => 'required|exists:menus,idmenu',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        // Buat pesanan baru
        $pesanan = Pesanan::create([
            'idpelanggan' => $request->idpelanggan,
            'iduser' => auth()->id(),
        ]);

        // Simpan detail pesanan
        foreach ($request->items as $item) {
            DetailPesanan::create([
                'idpesanan' => $pesanan->idpesanan,
                'idmenu' => $item['idmenu'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('pesanans.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['detailPesanans.menu', 'pelanggan', 'user']);
        return view('pesanans.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $pesanan->load(['detailPesanans.menu']);
        return view('pesanans.edit', compact('pesanan', 'menus', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
            'items' => 'required|array|min:1',
            'items.*.idmenu' => 'required|exists:menus,idmenu',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        // Update pesanan
        $pesanan->update([
            'idpelanggan' => $request->idpelanggan,
        ]);

        // Hapus detail pesanan lama
        $pesanan->detailPesanans()->delete();

        // Simpan detail pesanan baru
        foreach ($request->items as $item) {
            DetailPesanan::create([
                'idpesanan' => $pesanan->idpesanan,
                'idmenu' => $item['idmenu'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('pesanans.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanans.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}