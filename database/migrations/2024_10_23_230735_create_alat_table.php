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
        Schema::create('alat', function (Blueprint $table) {
            $table->string('id_alat')->primary(); // Gabungan id_bph + angka increment sebagai primary key
            $table->string('id_bph', 2);
            $table->string('nama_alat');
            $table->text('deskripsi');
            $table->integer('jumlah_tersedia');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('id_bph')->references('id_bph')->on('bph')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
