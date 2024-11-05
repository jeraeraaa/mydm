<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriKegiatan;

class KategoriKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriKegiatan::insert([
            ['nama_kategori' => 'BPH', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Program Kerja', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
