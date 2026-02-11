<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    // Tentukan field mana saja yang boleh diisi
    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'kategori_id', // Ini harus ada untuk menghubungkan ke kategori
        'kondisi',
        'jumlah'
    ];

    // DEFINISIKAN RELASI: Satu Alat memiliki satu Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // --- INI TAMBAHANNYA ---
    // Relasi: Satu alat (Sapu/Pel) bisa dicatat dalam banyak transaksi peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}