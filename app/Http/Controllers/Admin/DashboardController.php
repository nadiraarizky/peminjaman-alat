<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat; // Tambahkan ini
use App\Models\Peminjaman; // Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung total semua alat yang terdaftar
        $totalAlat = Alat::count();

        // 2. Menghitung total denda dari seluruh transaksi peminjaman
        // Pastikan nama kolom di database kamu adalah 'denda'
        $totalDenda = Peminjaman::sum('denda');

        // 3. Mengirim data ke view admin/dashboard.blade.php
        return view('admin.dashboard', compact('totalAlat', 'totalDenda'));
    }
}