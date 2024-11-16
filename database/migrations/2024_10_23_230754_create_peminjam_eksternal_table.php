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
        Schema::create('peminjam_eksternal', function (Blueprint $table) {
            $table->string('id_peminjam_eksternal', 10)->primary(); // NIM sebagai primary key
            $table->string('id_prodi', 3); // Foreign key untuk program_studi
            $table->string('nama');
            $table->string('organisasi');
            $table->timestamps();

            // Foreign key constraint untuk menghubungkan ke tabel program_studi
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjam_eksternal');
    }
};
