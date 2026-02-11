<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Lihat semua daftar pengajuan yang sedang menunggu (Pending)
    public function index() {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('admin.peminjamans.index', compact('peminjamans'));
    }

    // Fungsi untuk menyetujui pinjaman
    public function approve($id) {
        $pinjam = Peminjaman::findOrFail($id);
        
        // Sesuaikan 'jumlah_pinjam' dengan nama kolom di database kamu
        if ($pinjam->alat->jumlah < $pinjam->jumlah_pinjam) {
            return back()->with('error', 'Stok alat tidak mencukupi untuk disetujui!');
        }

        // Kurangi stok alat dan ubah status ke 'dipinjam' (sesuai ENUM database)
        $pinjam->alat->decrement('jumlah', $pinjam->jumlah_pinjam);
        $pinjam->update(['status' => 'dipinjam']);

        return back()->with('success', 'Peminjaman telah disetujui!');
    }

    // Fungsi untuk menolak
    public function reject($id) {
        Peminjaman::findOrFail($id)->update(['status' => 'ditolak']);
        return back()->with('success', 'Peminjaman telah ditolak!');
    }

    // --- FUNGSI RIWAYAT BARU UNTUK ADMIN ---
    public function history() {
        // Mengambil data yang statusnya bukan pending (sesuaikan dengan status di database)
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['dipinjam', 'ditolak', 'dikembalikan'])
            ->latest()
            ->get();
            
        return view('admin.peminjamans.history', compact('peminjamans'));
    }
}