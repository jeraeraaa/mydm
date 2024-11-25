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
        Schema::create('materi', function (Blueprint $table) {
            $table->id('id_materi');
            $table->unsignedBigInteger('id_detail_kegiatan'); // Foreign key ke detail_kegiatan
            $table->unsignedBigInteger('id_pembicara')->nullable(); // Foreign key ke pembicara (boleh null jika tidak wajib)
            $table->string('nama_materi');
            $table->text('deskripsi_materi')->nullable(); // Menggunakan tipe text untuk deskripsi yang lebih panjang
            // $table->timestamps();

            // Relasi ke detail_kegiatan
            $table->foreign('id_detail_kegiatan')->references('id_detail_kegiatan')->on('detail_kegiatan')->onDelete('cascade');
            // Relasi ke pembicara (nullable jika tidak selalu ada pembicara)
            $table->foreign('id_pembicara')->references('id_pembicara')->on('pembicara')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
