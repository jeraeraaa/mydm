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
        Schema::create('detail_kegiatan', function (Blueprint $table) {
            $table->id('id_detail_kegiatan');
            $table->string('id_bph', 2)->nullable();
            $table->unsignedBigInteger('id_kegiatan');
            $table->string('nama_detail_kegiatan');
            $table->text('deskripsi_detail');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('lokasi');
            $table->string('foto')->nullable();
            $table->timestamps();

            // Foreign Key ke tabel kegiatan
            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('kegiatan')->onDelete('cascade');

            // Foreign Key ke tabel bph
            $table->foreign('id_bph')->references('id_bph')->on('bph')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kegiatan');
    }
};
