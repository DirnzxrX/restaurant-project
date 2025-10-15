<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mejas = Meja::orderBy('nomor_meja')->get();
        return view('mejas.index', compact('mejas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mejas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:10|unique:mejas',
            'kapasitas' => 'required|integer|min:1|max:20',
            'status' => 'required|in:tersedia,terisi,reserved',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Meja::create($request->all());

        return redirect()->route('mejas.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meja $meja)
    {
        $meja->load('pesanans.menu', 'pesanans.pelanggan');
        return view('mejas.show', compact('meja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        return view('mejas.edit', compact('meja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:10|unique:mejas,nomor_meja,' . $meja->idmeja . ',idmeja',
            'kapasitas' => 'required|integer|min:1|max:20',
            'status' => 'required|in:tersedia,terisi,reserved',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $meja->update($request->all());

        return redirect()->route('mejas.index')->with('success', 'Meja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect()->route('mejas.index')->with('success', 'Meja berhasil dihapus.');
    }
}
