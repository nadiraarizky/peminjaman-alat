<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import library PDF

class LogController extends Controller
{
    /**
     * Menampilkan daftar log aktivitas di dashboard.
     */
    public function index()
    {
        // Mengambil log terbaru dan data user yang bersangkutan
        $logs = ActivityLog::with('user')->latest()->get();

        return view('admin.logs.index', compact('logs'));
    }

    /**
     * Fungsi untuk mencetak laporan log aktivitas ke format PDF.
     */
    public function exportPDF()
    {
        // Mengambil semua data log untuk dicetak
        $logs = ActivityLog::with('user')->latest()->get();

        // Mengatur view yang akan dijadikan PDF
        $pdf = Pdf::loadView('admin.logs.pdf', compact('logs'));

        // Mengatur ukuran kertas (A4) dan orientasi (Landscape agar muat banyak kolom)
        $pdf->setPaper('a4', 'landscape');

        // Download file PDF dengan nama yang rapi
        return $pdf->download('Laporan_Aktivitas_Sistem_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Fungsi opsional untuk menghapus semua log (Clear Logs).
     */
    public function destroyAll()
    {
        ActivityLog::truncate();
        return redirect()->route('admin.logs.index')->with('success', 'Semua riwayat aktivitas berhasil dihapus!');
    }
}