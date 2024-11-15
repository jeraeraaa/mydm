<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->string('id_inventaris')->primary();
            $table->string('id_anggota', 10); // Menambahkan kolom id_anggota sebagai foreign key
            $table->year('tahun_jabatan');
            
            $table->timestamps();

            // Foreign key constraint untuk menghubungkan ke tabel anggota
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
