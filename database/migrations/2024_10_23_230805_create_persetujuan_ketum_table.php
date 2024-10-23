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
        Schema::create('persetujuan_ketum', function (Blueprint $table) {
            $table->id('id_persetujuan_ketum');
            $table->unsignedBigInteger('id_ketum');
            $table->boolean('status_persetujuan');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_ketum')->references('id_ketum')->on('ketua_umum')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persetujuan_ketum');
    }
};
