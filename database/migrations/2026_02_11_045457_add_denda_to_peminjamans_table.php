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
        Schema::table('peminjamans', function (Blueprint $table) {
            // Menambahkan kolom denda setelah kolom status
            // Kita pakai tipe decimal agar bisa menyimpan nominal uang dengan rapi
            $table->decimal('denda', 12, 2)->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Menghapus kolom denda jika migrasi di-rollback
            $table->dropColumn('denda');
        });
    }
};