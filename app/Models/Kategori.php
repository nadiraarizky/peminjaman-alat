<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    // Relasi: Satu Kategori bisa punya banyak Alat
    public function alats()
    {
        return $this->hasMany(Alat::class, 'kategori_id');
    }
}