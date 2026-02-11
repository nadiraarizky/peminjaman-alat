<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        // Kita ambil data alat (Sapu, Pel, dll) yang stoknya masih ada
        $alats = Alat::where('jumlah', '>', 0)->get();

        // Kita arahkan ke folder yang baru saja kamu buat tadi
        return view('user.alats.index', compact('alats'));
    }
}