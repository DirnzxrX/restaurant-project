<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['menu', 'pelanggan', 'user'])->get();
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
            'idmenu' => 'required|exists:menus,idmenu',
            'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
            'jumlah' => 'required|integer|min:1',
        ]);

        $request->merge(['iduser' => auth()->id()]);

        Pesanan::create($request->all());

        return redirect()->route('pesanans.index')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['menu', 'pelanggan', 'user']);
        return view('pesanans.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        return view('pesanans.edit', compact('pesanan', 'menus', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'idmenu' => 'required|exists:menus,idmenu',
            'idpelanggan' => 'required|exists:pelanggans,idpelanggan',
            'jumlah' => 'required|integer|min:1',
        ]);

        $pesanan->update($request->all());

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