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
        Schema::create('program_studi', function (Blueprint $table) {
            $table->string('id_prodi', 3)->primary(); // 3 digit pertama dari NIM sebagai kode prodi
            $table->unsignedBigInteger('id_fakultas');
            $table->string('nama_prodi');
            // $table->timestamps();

            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
