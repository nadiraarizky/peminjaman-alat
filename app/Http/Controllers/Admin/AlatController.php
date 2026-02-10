<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    // Tampil semua alat
    public function index()
    {
        $alats = Alat::all();
        return view('admin.alats.index', compact('alats'));
    }

    // Form tambah alat
    public function create()
    {
        return view('admin.alats.create');
    }

    // Simpan alat baru
  public function store(Request $request)
{
    $request->validate([
        'nama_alat' => 'required|string|max:255',
        'kode_alat' => 'required|string|unique:alats,kode_alat',
        'kondisi' => 'nullable|string|max:100',
        'jumlah' => 'required|integer|min:0',
    ]);

    Alat::create($request->only([
        'nama_alat',
        'kode_alat',
        'kondisi',
        'jumlah'
    ]));

    return redirect()
        ->route('alats.index')
        ->with('success', 'Alat berhasil ditambahkan.');
}

    // Tampil detail alat (optional)
    public function show($id)
    {
        $alat = Alat::findOrFail($id);
        return view('admin.alats.show', compact('alat'));
    }

    // Form edit alat
    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        return view('admin.alats.edit', compact('alat'));
    }

    // Update alat
    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:alats,kode_alat,'.$alat->id,
            'kondisi' => 'nullable|string|max:100',
            'jumlah' => 'required|integer|min:0',
        ]);

        $alat->update($request->all());

        return redirect()->route('alats.index')->with('success', 'Alat berhasil diupdate.');
    }

    // Hapus alat
    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();

        return redirect()->route('alats.index')->with('success', 'Alat berhasil dihapus.');
    }
}
