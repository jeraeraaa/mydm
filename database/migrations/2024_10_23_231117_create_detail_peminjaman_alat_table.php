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
            $table->id('id_detail_peminjaman_alat'); // Primary key
            $table->morphs('peminjamable'); // Polymorphism untuk peminjam (anggota atau eksternal)
            $table->string('id_alat'); // Foreign key untuk alat
            $table->string('id_inventaris')->nullable(); // Foreign key untuk inventaris (nullable)
            $table->unsignedBigInteger('id_persetujuan_ketum')->nullable(); // Foreign key untuk persetujuan ketum (nullable)
            $table->string('id_grup_peminjaman')->nullable(); // Kolom tambahan untuk mengelompokkan peminjaman
            $table->date('tanggal_pinjam'); // Tanggal peminjaman
            $table->date('tanggal_kembali')->nullable(); // Tanggal pengembalian (nullable)
            $table->boolean('is_returned')->default(false);
            $table->string('kondisi_alat_dipinjam'); // Kondisi alat saat dipinjam
            $table->string('kondisi_setelah_dikembalikan')->nullable(); // Kondisi alat setelah dikembalikan (nullable)
            $table->text('catatan')->nullable(); // Catatan tambahan (nullable)
            $table->integer('jumlah_dipinjam'); // Jumlah alat yang dipinjam
            // $table->timestamps(); // Timestamps

            // Foreign key relationships
            $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('cascade');
            $table->foreign('id_persetujuan_ketum')->references('id_persetujuan_ketum')->on('persetujuan_ketum')->onDelete('cascade');
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
            $table->dropForeign(['id_alat']);
            $table->dropForeign(['id_persetujuan_ketum']);
            $table->dropColumn('is_returned');
        });

        Schema::dropIfExists('detail_peminjaman_alat');
    }
};
