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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            // Relasi User & Alat
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            
            $table->integer('jumlah_pinjam');
            
            // PAKAI dateTime: Agar jam tidak 00:00 terus
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->nullable(); 
            
            // PERBAIKAN: Tambahkan 'ditolak' ke dalam array enum
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'ditolak'])->default('pending');
            
            // KOLOM DENDA: Tetap simpan di sini
            $table->decimal('denda', 12, 2)->default(0); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};