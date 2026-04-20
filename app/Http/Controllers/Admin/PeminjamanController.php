<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar permintaan peminjaman (Pending)
     */
    public function index() {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('admin.peminjamans.index', compact('peminjamans'));
    }

    /**
     * Menyetujui peminjaman dan mengurangi stok alat
     */
    public function approve($id) {
        $pinjam = Peminjaman::findOrFail($id);
        
        if ($pinjam->alat->jumlah < $pinjam->jumlah_pinjam) {
            return back()->with('error', 'Stok alat tidak mencukupi!');
        }

        $pinjam->alat->decrement('jumlah', $pinjam->jumlah_pinjam);
        $pinjam->update(['status' => 'dipinjam']);

        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    /**
     * Menolak permintaan peminjaman
     */
    public function reject($id) {
        Peminjaman::findOrFail($id)->update(['status' => 'ditolak']);
        return back()->with('success', 'Permintaan peminjaman ditolak!');
    }

    /**
     * Menampilkan riwayat peminjaman (Selesai/Ditolak/Sedang Dipinjam)
     */
    public function history() {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['dipinjam', 'ditolak', 'dikembalikan'])
            ->latest()
            ->get();
        return view('admin.peminjamans.history', compact('peminjamans'));
    }

    /**
     * Mencatat pembayaran denda secara tunai
     */
    public function payDenda($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Update kolom denda menjadi 0
        $peminjaman->update(['denda' => 0]);

        return back()->with('success', 'Pembayaran tunai berhasil dicatat. Denda telah lunas!');
    }

    /**
     * Export data ke PDF berdasarkan periode yang dipilih
     */
    public function exportPDF(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat'])
                 ->whereIn('status', ['dipinjam', 'ditolak', 'dikembalikan']);

        // --- Inisialisasi Variabel Default (PENTING AGAR TIDAK ERROR) ---
        $title = "Laporan Peminjaman Alat Sarpras";
        $label = "Semua Riwayat Peminjaman";
        $date  = Carbon::now()->translatedFormat('d F Y'); // Untuk tanggal cetak di PDF

        // --- Logika Filter Periode ---
        if ($request->periode == 'harian') {
            $query->whereDate('tanggal_pinjam', Carbon::today());
            $label = "Laporan Harian (" . Carbon::today()->translatedFormat('d F Y') . ")";
        } 
        elseif ($request->periode == 'mingguan') {
            $start = Carbon::now()->startOfWeek()->format('Y-m-d');
            $end = Carbon::now()->endOfWeek()->format('Y-m-d');
            
            $query->whereBetween('tanggal_pinjam', [$start, $end]);
            $label = "Laporan Mingguan (" . Carbon::parse($start)->translatedFormat('d M') . " - " . Carbon::parse($end)->translatedFormat('d M Y') . ")";
        } 
        elseif ($request->periode == 'bulanan') {
            $query->whereMonth('tanggal_pinjam', Carbon::now()->month)
                  ->whereYear('tanggal_pinjam', Carbon::now()->year);
            $label = "Laporan Bulanan (" . Carbon::now()->translatedFormat('F Y') . ")";
        } 
        elseif ($request->periode == 'custom') {
            if ($request->tgl_mulai && $request->tgl_selesai) {
                $query->whereDate('tanggal_pinjam', '>=', $request->tgl_mulai)
                      ->whereDate('tanggal_pinjam', '<=', $request->tgl_selesai);
                
                $label = "Laporan Periode: " . Carbon::parse($request->tgl_mulai)->translatedFormat('d M Y') . " s/d " . Carbon::parse($request->tgl_selesai)->translatedFormat('d M Y');
            }
        }

        // Ambil data berdasarkan filter
        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();

        // --- Load View dan Kirim Semua Variabel (Peminjamans, Title, Label, Date) ---
        $pdf = PDF::loadView('admin.peminjamans.pdf', compact('peminjamans', 'title', 'label', 'date'));
        
        // Download atau Stream ke Browser
        return $pdf->stream('Laporan_Peminjaman_Sarpras_' . date('Ymd_His') . '.pdf');
    }
}