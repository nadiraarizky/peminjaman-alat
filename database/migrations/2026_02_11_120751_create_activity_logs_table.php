<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (siapa yang beraksi)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom untuk judul aktivitas (misal: "Tambah Alat", "Hapus Kategori")
            $table->string('activity');
            
            // Kolom untuk detail pesan (misal: "Admin menghapus alat Kamera Canon")
            $table->text('description');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};