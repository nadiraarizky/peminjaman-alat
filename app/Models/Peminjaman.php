<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'denda' => 'integer', // Ubah ke integer agar tidak ada desimal .00
    ];

    // --- LOGIKA PERBAIKAN DENDA & WAKTU ---

    /**
     * Menghitung status keterlambatan secara dinamis
     * Akan menghasilkan teks seperti "3 jam yang lalu"
     */
    public function getStatusTerlambatAttribute()
    {
        if ($this->status == 'dipinjam' && Carbon::now() > $this->tanggal_kembali) {
            // diffForHumans() otomatis mengubah selisih waktu menjadi teks manusia
            return 'Terlambat ' . $this->tanggal_kembali->diffForHumans(null, true) . ' yang lalu';
        }
        return null;
    }

    /**
     * Aksesor untuk format mata uang denda yang rapi
     */
    public function getFormatDendaAttribute()
    {
        // Jika denda di database 0 tapi statusnya terlambat, kita bisa tampilkan estimasi 5000
        $nominal = ($this->denda > 0) ? $this->denda : 5000;
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }

    // --- RELATIONSHIPS & SCOPES ---

    public function scopeSelesai($query)
    {
        return $query->whereIn('status', ['dikembalikan', 'ditolak']);
    }

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