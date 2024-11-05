<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bph;

class BphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bph::insert([
            ['id_bph' => 'BK', 'nama_divisi_bph' => 'Bakti', 'created_at' => now(), 'updated_at' => now()],
            ['id_bph' => 'BM', 'nama_divisi_bph' => 'Bakat dan Minat', 'created_at' => now(), 'updated_at' => now()],
            ['id_bph' => 'HM', 'nama_divisi_bph' => 'Hubungan Masyarakat', 'created_at' => now(), 'updated_at' => now()],
            ['id_bph' => 'IN', 'nama_divisi_bph' => 'Inti', 'created_at' => now(), 'updated_at' => now()],
            ['id_bph' => 'IV', 'nama_divisi_bph' => 'Inventaris', 'created_at' => now(), 'updated_at' => now()],
            ['id_bph' => 'MM', 'nama_divisi_bph' => 'Multimedia', 'created_at' => now(), 'updated_at' => now()],
            ['id_bph' => 'PD', 'nama_divisi_bph' => 'Perpustakaan, Pendidikan, dan Kesehatan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
