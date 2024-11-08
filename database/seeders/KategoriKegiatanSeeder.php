<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_kegiatan')->insert([
            [
                'nama_kategori' => 'BPH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Program Kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
