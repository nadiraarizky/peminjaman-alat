<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Halaman daftar pinjaman saya (yang masih pending atau sedang dipinjam)
    public function index()
    {
        $peminjamans = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'dipinjam']) // Sesuaikan dengan ENUM database kamu
            ->latest()
            ->get();
        return view('user.peminjamans.index', compact('peminjamans'));
    }

    // Menampilkan Form Pinjam
    public function create(Request $request)
    {
        $alat = Alat::findOrFail($request->alat_id);
        return view('user.peminjamans.create', compact('alat'));
    }

    // Proses menyimpan data pinjaman
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        Peminjaman::create([
            'user_id'        => Auth::id(),
            'alat_id'        => $request->alat_id,
            'jumlah_pinjam'  => $request->jumlah,
            'tanggal_pinjam' => now(), 
            'status'         => 'pending',
        ]);

        return redirect()->route('user.pinjam.index')->with('success', 'Permintaan peminjaman berhasil dikirim!');
    }

    // --- FUNGSI BARU: Proses Pengembalian Alat ---
    public function returnBack($id)
    {
        // Cari data pinjaman milik user ini yang statusnya 'dipinjam'
        $pinjam = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // 1. Tambahkan kembali stok ke tabel alats
        $pinjam->alat->increment('jumlah', $pinjam->jumlah_pinjam);
        
        // 2. Ubah status menjadi 'dikembalikan'
        $pinjam->update([
            'status' => 'dikembalikan'
        ]);

        return back()->with('success', 'Alat telah dikembalikan, terima kasih!');
    }

    // Halaman riwayat (untuk yang sudah ditolak atau dikembalikan)
    public function history()
    {
        $peminjamans = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['dikembalikan', 'ditolak']) // Sesuaikan dengan ENUM database
            ->latest()
            ->get();
        return view('user.peminjamans.history', compact('peminjamans'));
    }
}