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
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('id_anggota', 10)->primary(); // NIM sebagai primary key
            $table->string('id_prodi', 3); // 3 digit pertama dari NIM sebagai kode prodi
            $table->foreignId('id_role')->nullable()->constrained('roles')->onDelete('set null'); // Foreign key ke tabel roles
            $table->string('nama_anggota', 255);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp', 15);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']); // Laki-laki atau Perempuan
            $table->string('foto_profil')->nullable(); // Boleh kosong jika tidak ada foto
            $table->timestamps();

            // Foreign key ke tabel program_studi
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi')->onDelete('cascade');
            $table->foreignId('id_role')->nullable()->default(4)->constrained('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['id_prodi']); // Hapus foreign key ke tabel program_studi
            $table->dropForeign(['id_role']); // Hapus foreign key ke tabel roles
        });

        Schema::dropIfExists('anggota');
    }
};
