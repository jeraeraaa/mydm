<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Memanggil seeder tambahan untuk kategori kegiatan dan BPH
        $this->call([
            ProdiSeeder::class,
            AnggotaSeeder::class,
            KategoriKegiatanSeeder::class,
            BphSeeder::class,
            // Tambahkan seeder lain di sini jika diperlukan
        ]);
    }
}
