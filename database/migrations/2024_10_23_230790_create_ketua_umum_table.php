<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKetuaUmumTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ketua_umum', function (Blueprint $table) {
            $table->id('id_ketum');
            $table->string('id_anggota', 10); // Menambahkan kolom id_anggota sebagai foreign key
            $table->year('tahun_jabatan');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketua_umum');
    }
}
