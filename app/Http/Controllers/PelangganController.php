<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggans.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namapelanggan' => 'required|string|max:255',
            'jeniskelamin' => 'required|boolean',
            'nohp' => 'required|string|max:12',
            'alamat' => 'required|string|max:95',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggans.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggans.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'namapelanggan' => 'required|string|max:255',
            'jeniskelamin' => 'required|boolean',
            'nohp' => 'required|string|max:12',
            'alamat' => 'required|string|max:95',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}