<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. MENGHITUNG PINJAMAN SAYA (KOTAK UNGU)
        // Kita ganti 'SEDANG DIPINJAM' jadi 'dipinjam' sesuai isi TablePlus kamu
        $jumlahPinjaman = Peminjaman::where('user_id', $userId)
                            ->where('status', 'dipinjam')
                            ->count();

        // 2. MENGHITUNG TOTAL DENDA (KOTAK PINK)
        // Menjumlahkan semua isi kolom denda milik kamu
        $totalDenda = Peminjaman::where('user_id', $userId)->sum('denda');

        return view('user.dashboard', compact('jumlahPinjaman', 'totalDenda'));
    }
}