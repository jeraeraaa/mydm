<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alat')->insert([
            [
                'id_alat' => 'BK-001',
                'id_bph' => 'BK',
                'nama_alat' => 'Bowl Blessing',
                'deskripsi' => 'Bowl/mangkuk yang digunakan dalam pemeriksaan air tirta',
                'jumlah_tersedia' => 10,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BM-001',
                'id_bph' => 'BM',
                'nama_alat' => 'Bowl Kaca',
                'deskripsi' => 'Mangkok berbahan kaca, biasanya dipakai untuk mengisi air dalam prosesi puja',
                'jumlah_tersedia' => 2,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'HM-001',
                'id_bph' => 'HM',
                'nama_alat' => 'Hiolo',
                'deskripsi' => 'Tempat meletakkan hio',
                'jumlah_tersedia' => 2,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'IV-001',
                'id_bph' => 'IV',
                'nama_alat' => 'Vas Bunga',
                'deskripsi' => 'Vas untuk menempatkan bunga pada persembahan',
                'jumlah_tersedia' => 2,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'MM-001',
                'id_bph' => 'MM',
                'nama_alat' => 'Kamera Canon',
                'deskripsi' => 'Alas untuk menempatkan paritta',
                'jumlah_tersedia' => 2,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-002',
                'id_bph' => 'BK',
                'nama_alat' => 'Hio Altar',
                'deskripsi' => 'Hio yang digunakan di altar',
                'jumlah_tersedia' => 1,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-003',
                'id_bph' => 'BK',
                'nama_alat' => 'Hio Gunung Kawi',
                'deskripsi' => 'Hio yang digunakan pada saat amisa puja',
                'jumlah_tersedia' => 1,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-004',
                'id_bph' => 'BK',
                'nama_alat' => 'Nampan',
                'deskripsi' => 'Baki untuk membawa persembahan',
                'jumlah_tersedia' => 2,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-005',
                'id_bph' => 'BK',
                'nama_alat' => 'Gayung Rupang',
                'deskripsi' => 'Gayung yang digunakan untuk memandikan rupang Siddharta',
                'jumlah_tersedia' => 1,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-006',
                'id_bph' => 'BK',
                'nama_alat' => 'Mangkuk Merah',
                'deskripsi' => 'Mangkuk berwarna merah, digunakan untuk meletakkan persembahan makanan',
                'jumlah_tersedia' => 13,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-007',
                'id_bph' => 'BK',
                'nama_alat' => 'Hai Ching Putih',
                'deskripsi' => 'Pakaian pemimpin puja pada aliran Mahayana',
                'jumlah_tersedia' => 2,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-008',
                'id_bph' => 'BK',
                'nama_alat' => 'Hai Ching Hitam',
                'deskripsi' => 'Pakaian pemimpin puja pada aliran Mahayana',
                'jumlah_tersedia' => 5,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_alat' => 'BK-009',
                'id_bph' => 'BK',
                'nama_alat' => 'Hai Ching Kuning',
                'deskripsi' => 'Pakaian pemimpin puja pada aliran Mahayana',
                'jumlah_tersedia' => 5,
                'foto' => null,
                'status_alat' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
