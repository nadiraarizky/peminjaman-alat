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
        Schema::table('alats', function (Blueprint $table) {
            // Kita tambahkan kolom kategori_id setelah nama_alat
            $table->unsignedBigInteger('kategori_id')->after('nama_alat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            // Jika di-rollback, kolom ini dihapus kembali
            $table->dropColumn('kategori_id');
        });
    }
};