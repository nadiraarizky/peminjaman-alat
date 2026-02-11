<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\ActivityLog; // Tambahkan ini agar log bisa tercatat
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategoris.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        // --- CATAT LOG AKTIVITAS ---
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah Kategori',
            'description' => auth()->user()->name . ' menambah kategori baru: ' . $kategori->nama_kategori
        ]);

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);
        
        // Simpan nama lama untuk keterangan di log
        $namaLama = $kategori->nama_kategori;

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        // --- CATAT LOG AKTIVITAS ---
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update Kategori',
            'description' => auth()->user()->name . ' mengubah kategori "' . $namaLama . '" menjadi "' . $request->nama_kategori . '"'
        ]);

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // --- CATAT LOG AKTIVITAS (Sebelum Dihapus) ---
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Hapus Kategori',
            'description' => auth()->user()->name . ' menghapus kategori: ' . $kategori->nama_kategori
        ]);

        $kategori->delete();

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori Berhasil Dihapus!');
    }
}