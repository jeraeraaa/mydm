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
        Schema::create('pembicara', function (Blueprint $table) {
            $table->id('id_pembicara');
            $table->unsignedBigInteger('id_kegiatan'); // Foreign key untuk kegiatan
            $table->unsignedBigInteger('id_materi'); // Foreign key untuk materi
            $table->string('nama_pembicara');
            $table->string('kontak_pembicara');
            $table->timestamps();

            // Foreign key constraint untuk menghubungkan ke tabel kegiatan
            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('kegiatan')->onDelete('cascade');

            // Foreign key constraint untuk menghubungkan ke tabel materi
            $table->foreign('id_materi')->references('id_materi')->on('materi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembicara');
    }
};
