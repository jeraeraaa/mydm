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
        Schema::create('detail_peminjaman_alat', function (Blueprint $table) {
            $table->id('id_detail_peminjaman_alat');
            $table->morphs('peminjamable'); //polymorphism id_anggota dan id_peminjam_eksternal
            $table->string('id_alat');
            $table->string('id_inventaris')->nullable(); // Set as nullable without foreign key initially
            $table->unsignedBigInteger('id_persetujuan_ketum')->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->string('kondisi_alat_dipinjam');
            $table->string('kondisi_setelah_dikembalikan')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('jumlah_dipinjam');
            $table->timestamps();

            $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('cascade');
            $table->foreign('id_persetujuan_ketum')->references('id_persetujuan_ketum')->on('persetujuan_ketum')->onDelete('cascade');
        });

        // Add foreign key constraint in separate migration
        Schema::table('detail_peminjaman_alat', function (Blueprint $table) {
            $table->foreign('id_inventaris')->references('id_inventaris')->on('inventaris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_peminjaman_alat', function (Blueprint $table) {
            $table->dropForeign(['id_inventaris']);
        });

        Schema::dropIfExists('detail_peminjaman_alat');
    }
};
