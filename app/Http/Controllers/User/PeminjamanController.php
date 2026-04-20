<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar pinjaman (Pending & Dipinjam)
     */
    public function index()
    {
        // Pastikan relasi 'alat' ada di Model Peminjaman
        $peminjamans = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'dipinjam'])
            ->latest()
            ->get();
        
        return view('user.peminjamans.index', compact('peminjamans'));
    }

    /**
     * Simpan Pinjaman - PERBAIKAN SINKRONISASI INPUT
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Nama field disamakan dengan <input name="..."> di View
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah_pinjam' => 'required|integer|min:1', 
        ]);

        // Simpan data peminjaman
        $peminjaman = Peminjaman::create([
            'user_id'         => Auth::id(),
            'alat_id'         => $request->alat_id,
            'jumlah_pinjam'   => $request->jumlah_pinjam, // Sesuai input form
            'tanggal_pinjam'  => now(), 
            'status'          => 'pending',
            'tanggal_kembali' => now()->addDays(3), // Default kasih 3 hari atau sesuai kebijakan
        ]);

        $alat = Alat::find($request->alat_id);

        // Redirect kembali ke halaman index peminjaman
        return redirect()->route('user.pinjam.index')
            ->with('status_sukses', "Permintaan pinjam " . $alat->nama_alat . " berhasil dikirim! Menunggu persetujuan admin.");
    }

    /**
     * Fitur Kembalikan Alat
     */
    public function returnBack($id)
    {
        $pinjam = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        $tgl_sekarang = Carbon::now();
        $tgl_deadline = Carbon::parse($pinjam->tanggal_kembali);
        $total_denda = 0;

        // Hitung Denda
        if ($tgl_sekarang->gt($tgl_deadline)) {
            $selisih_hari = $tgl_sekarang->diffInDays($tgl_deadline);
            if($selisih_hari <= 0) $selisih_hari = 1;
            $total_denda = $selisih_hari * 5000; 
        }

        // Kembalikan stok alat
        if ($pinjam->alat) {
            $pinjam->alat->increment('jumlah', $pinjam->jumlah_pinjam);
        }
        
        $pinjam->update([
            'status' => 'dikembalikan',
            'denda'  => $total_denda,
            'tanggal_pengembalian' => $tgl_sekarang 
        ]);

        return back()->with('status_sukses', 'Alat telah dikembalikan.' . ($total_denda > 0 ? ' Denda: Rp '.number_format($total_denda,0,',','.') : ''));
    }

    public function history()
    {
        $peminjamans = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->latest()
            ->get();
            
        return view('user.peminjamans.history', compact('peminjamans'));
    }
}