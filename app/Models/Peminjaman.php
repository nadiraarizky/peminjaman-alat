<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 
        'alat_id', 
        'jumlah_pinjam', 
        'tanggal_pinjam', 
        'tanggal_kembali',
        'status',
        'denda'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'jumlah_pinjam' => 'integer',
        'denda' => 'decimal:2',
    ];

    // --- TAMBAHAN BIAR MAKIN OKE ---

    /**
     * Scope untuk mempermudah filter di Controller (buat Laporan PDF)
     * Jadi di Controller cukup panggil: Peminjaman::selesai()->get()
     */
    public function scopeSelesai($query)
    {
        return $query->whereIn('status', ['dikembalikan', 'ditolak']);
    }

    /**
     * Aksesor untuk format mata uang denda
     * Biar di laporan PDF langsung muncul "Rp 5.000"
     */
    public function getFormatDendaAttribute()
    {
        return 'Rp ' . number_format($this->denda, 0, ',', '.');
    }

    // --- RELATIONSHIPS ---

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'User Terhapus'
        ]);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id')->withDefault([
            'nama_alat' => 'Alat Terhapus'
        ]);
    }
}