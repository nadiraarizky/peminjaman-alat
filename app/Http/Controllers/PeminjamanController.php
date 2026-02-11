<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
// Pastikan kamu sudah punya model Peminjaman, jika belum ganti sesuai nama modelmu
// use App\Models\Peminjaman; 

class PeminjamanController extends Controller
{
    public function store(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);
        
        // Validasi stok
        if ($alat->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        // Simpan data (Sesuaikan dengan nama tabel/model kamu)
        // Peminjaman::create([
        //     'user_id' => auth()->id(),
        //     'alat_id' => $alat->id,
        //     'jumlah' => $request->jumlah,
        //     'status' => 'pending',
        // ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim!');
    }
}