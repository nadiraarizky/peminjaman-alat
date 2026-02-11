<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Tentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'activity',
        'description'
    ];

    /**
     * Relasi ke Model User
     * Log ini dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}