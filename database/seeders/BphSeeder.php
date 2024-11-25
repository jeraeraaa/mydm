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
            ['id_bph' => 'BK', 'nama_divisi_bph' => 'Bakti',],
            ['id_bph' => 'BM', 'nama_divisi_bph' => 'Bakat dan Minat',],
            ['id_bph' => 'HM', 'nama_divisi_bph' => 'Hubungan Masyarakat',],
            ['id_bph' => 'IN', 'nama_divisi_bph' => 'Inti',],
            ['id_bph' => 'IV', 'nama_divisi_bph' => 'Inventaris',],
            ['id_bph' => 'MM', 'nama_divisi_bph' => 'Multimedia',],
            ['id_bph' => 'PD', 'nama_divisi_bph' => 'Perpustakaan, Pendidikan, dan Kesehatan',],
        ]);
    }
}
