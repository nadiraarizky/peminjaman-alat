<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Alat; // Pastikan Model Alat di-import
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PeminjamanManagementController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('admin.peminjamans.index', compact('peminjamans'));
    }

    /**
     * Menyetujui Peminjaman & Mengurangi Stok
     */
    public function approve(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = $peminjaman->alat;

        // Cek apakah stok mencukupi sebelum dikurangi
        if ($alat->jumlah < $peminjaman->jumlah_pinjam) {
            return redirect()->back()->with('error', 'Gagal! Stok ' . $alat->nama_alat . ' tidak mencukupi.');
        }

        // 1. Kurangi stok barang
        $alat->decrement('jumlah', $peminjaman->jumlah_pinjam);

        // 2. Update data peminjaman
        $peminjaman->tanggal_kembali = $request->tanggal_kembali . ' ' . $request->jam_kembali; 
        $peminjaman->status = 'dipinjam'; 
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui dan stok berhasil dikurangi!');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'ditolak';
        $peminjaman->save();

        return redirect()->back()->with('error', 'Peminjaman telah ditolak.');
    }

    /**
     * FUNGSI BARU: Memproses Pengembalian & Mengembalikan Stok
     */
    public function returnBarang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan hanya yang statusnya 'dipinjam' yang bisa dikembalikan
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Barang ini tidak dalam status dipinjam.');
        }

        // 1. Tambahkan kembali stok barang
        $peminjaman->alat->increment('jumlah', $peminjaman->jumlah_pinjam);

        // 2. Update status jadi dikembalikan
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Barang dikembalikan & stok otomatis bertambah!');
    }

    // --- TAMBAHAN UNTUK CRUD PENGEMBALIAN (ADMIN) ---

    public function indexPengembalian()
    {
        $pengembalians = Peminjaman::with(['user', 'alat'])
                        ->where('status', 'dikembalikan')
                        ->latest()
                        ->get();

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function destroyPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->back()->with('success', 'Data pengembalian berhasil dihapus!');
    }

    // --- FITUR LAPORAN ---

    public function exportPDF()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
                        ->whereIn('status', ['dikembalikan', 'ditolak'])
                        ->latest()
                        ->get();

        $data = [
            'title' => 'Laporan Riwayat Peminjaman Alat',
            'date' => date('d/m/Y'),
            'peminjamans' => $peminjamans
        ];

        $pdf = Pdf::loadView('admin.peminjamans.pdf', $data);
        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }
}