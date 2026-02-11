<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; // Pastikan Model Peminjaman sudah ada
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanManagementController extends Controller
{
    public function exportPDF()
    {
        // Ambil data yang sudah selesai (dikembalikan/ditolak)
        $peminjamans = Peminjaman::with(['user', 'alat'])
                        ->whereIn('status', ['dikembalikan', 'ditolak'])
                        ->latest()
                        ->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'title' => 'Laporan Riwayat Peminjaman Alat',
            'date' => date('d/m/Y'),
            'peminjamans' => $peminjamans
        ];

        // Load view pdf.blade.php
        $pdf = Pdf::loadView('admin.peminjamans.pdf', $data);

        // Download file
        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }
}