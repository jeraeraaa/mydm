<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->string('id_anggota', 10)->nullable(); // Nullable untuk absensi pengunjung
            $table->unsignedBigInteger('id_pengunjung')->nullable(); // Nullable untuk absensi anggota
            $table->unsignedBigInteger('id_detail_kegiatan');
            $table->timestamp('waktu_masuk')->default(DB::raw('CURRENT_TIMESTAMP')); // Beri nilai default
            $table->timestamps();

            // Foreign key ke tabel anggota (opsional)
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');

            // Foreign key ke tabel pengunjung
            $table->foreign('id_pengunjung')->references('id_pengunjung')->on('pengunjung')->onDelete('cascade');

            // Foreign key ke tabel detail_kegiatan
            $table->foreign('id_detail_kegiatan')->references('id_detail_kegiatan')->on('detail_kegiatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
