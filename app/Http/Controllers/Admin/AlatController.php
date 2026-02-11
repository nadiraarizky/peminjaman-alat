<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat; 
use App\Models\Kategori; 
use App\Models\ActivityLog; // Tambahkan ini agar bisa mencatat log
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->get();
        return view('admin.alats.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alats.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_alat'   => 'required|unique:alats,kode_alat',
            'nama_alat'   => 'required',
            'kategori_id' => 'required',
            'kondisi'     => 'required',
            'jumlah'      => 'required|numeric',
        ]);

        $alat = Alat::create($request->all());

        // --- CATAT LOG AKTIVITAS ---
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah Alat',
            'description' => auth()->user()->name . ' menambahkan alat baru: ' . $alat->nama_alat . ' (' . $alat->kode_alat . ')'
        ]);

        return redirect()->route('admin.alats.index')->with('success', 'Data alat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id); 
        $kategoris = Kategori::all(); 
        return view('admin.alats.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'kode_alat'   => 'required|unique:alats,kode_alat,' . $id,
            'nama_alat'   => 'required',
            'kategori_id' => 'required',
            'kondisi'     => 'required',
            'jumlah'      => 'required|numeric',
        ]);

        $alat->update($request->all());

        // --- CATAT LOG AKTIVITAS ---
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update Alat',
            'description' => auth()->user()->name . ' memperbarui data alat: ' . $alat->nama_alat
        ]);

        return redirect()->route('admin.alats.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        // --- CATAT LOG AKTIVITAS (Sebelum Dihapus) ---
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Hapus Alat',
            'description' => auth()->user()->name . ' menghapus alat: ' . $alat->nama_alat
        ]);

        $alat->delete();

        return redirect()->route('admin.alats.index')->with('success', 'Data alat berhasil dihapus!');
    }
}