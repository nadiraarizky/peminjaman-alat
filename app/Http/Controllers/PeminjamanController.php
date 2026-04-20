<?php

namespace App\Http\Controllers\User; // Perhatikan namespace ini sudah benar untuk folder User

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar pinjaman milik user yang sedang login
     */
    public function index()
    {
        $peminjamans = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pinjam.index', compact('peminjamans'));
    }

    /**
     * Menyimpan data pengajuan pinjaman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $alat = Alat::findOrFail($request->alat_id);
        
        if ($alat->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $alat->id,
            'jumlah_pinjam' => $request->jumlah,
            'status' => 'pending',
            'tanggal_pinjam' => now(),
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim!');
    }

    /**
     * Fungsi Pengembalian Alat (Memperbaiki denda agar pas Rp 5.000)
     */
    public function returnBack($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $tenggat = Carbon::parse($peminjaman->tanggal_kembali);
        $sekarang = now();
        $denda = 0;

        // Logika pembulatan agar denda tidak muncul angka pecahan seperti 4.655
        if ($sekarang->isAfter($tenggat)) {
            $menitTerlambat = $sekarang->diffInMinutes($tenggat);
            
            // CEIL: Telat 1 menit pun akan dibulatkan menjadi 1 hari penuh (Rp 5.000)
            $hariTerlambat = ceil($menitTerlambat / 1440);
            
            if($hariTerlambat <= 0) $hariTerlambat = 1;

            $denda = $hariTerlambat * 5000;
        }

        // 1. Update status dan simpan denda yang sudah bulat (5000) ke database
        $peminjaman->update([
            'status' => 'dikembalikan',
            'denda' => $denda,
            'tanggal_pengembalian' => $sekarang
        ]);

        // 2. Tambahkan kembali stok alat ke tabel alats
        if ($peminjaman->alat) {
            $peminjaman->alat->increment('stok', $peminjaman->jumlah_pinjam);
        }

        return redirect()->route('user.pinjam.index')->with('success', "Alat telah dikembalikan. Anda terlambat dan dikenakan denda: Rp " . number_format($denda, 0, ',', '.'));
    }

    /**
     * Menampilkan riwayat peminjaman user
     */
    public function history()
    {
        $history = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'dikembalikan')
            ->get();
            
        return view('user.pinjam.history', compact('history'));
    }
}