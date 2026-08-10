<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Jenis::class);

        $jenisList = Jenis::orderBy('nama')->paginate(10);

        return view('jenis.index', compact('jenisList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Jenis::class);

        return view('jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Jenis::class);

        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis,nama',
        ], [
            'nama.required' => 'Nama jenis wajib diisi.',
            'nama.unique' => 'Nama jenis ini sudah ada.',
        ]);

        Jenis::create($data);

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis $jenis)
    {
        $this->authorize('update', $jenis);

        return view('jenis.edit', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jenis $jenis)
    {
        $this->authorize('update', $jenis);

        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis,nama,' . $jenis->id,
        ], [
            'nama.required' => 'Nama jenis wajib diisi.',
            'nama.unique' => 'Nama jenis ini sudah ada.',
        ]);

        $jenis->update($data);

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jenis)
    {
        $this->authorize('delete', $jenis);

        if ($jenis->produk()->exists()) {
            return redirect()->route('jenis.index')
                ->with('errors', 'Jenis tidak bisa dihapus karena masih dipakai oleh produk.');
        }

        $jenis->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil dihapus.');
    }
}