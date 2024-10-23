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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->unsignedBigInteger('id_kategori_kegiatan');
            $table->string('nama_kegiatan');
            $table->text('deskripsi_kegiatan');
            $table->timestamps();

            //foreign key ke kategori kegiatan
            $table->foreign('id_kategori_kegiatan')->references('id_kategori_kegiatan')->on('kategori_kegiatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
