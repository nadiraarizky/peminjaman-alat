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
            // Menghubungkan ke ID User (siapa yang pinjam)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Menghubungkan ke ID Alat (barang apa yang dipinjam)
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            
            $table->integer('jumlah_pinjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); // Boleh kosong kalau belum dibalikin
            
            // Status untuk memantau apakah barang sudah balik atau belum
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
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