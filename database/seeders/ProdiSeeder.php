<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;
use App\Models\Fakultas;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        // Data fakultas dan prodi yang telah disesuaikan
        $fakultasList = [
            'Fakultas Ekonomi dan Bisnis' => [
                ['id_prodi' => 115, 'nama_prodi' => 'Manajemen'],
                ['id_prodi' => 125, 'nama_prodi' => 'Akuntansi'],
            ],
            'Fakultas Hukum' => [
                ['id_prodi' => 205, 'nama_prodi' => 'Hukum'],
            ],
            'Fakultas Teknik' => [
                ['id_prodi' => 315, 'nama_prodi' => 'Arsitektur'],
                ['id_prodi' => 325, 'nama_prodi' => 'Teknik Sipil'],
                ['id_prodi' => 345, 'nama_prodi' => 'Perencanaan Wilayah dan Kota'],
                ['id_prodi' => 515, 'nama_prodi' => 'Teknik Mesin'],
                ['id_prodi' => 525, 'nama_prodi' => 'Teknik Elektro'],
                ['id_prodi' => 545, 'nama_prodi' => 'Teknik Industri'],
            ],
            'Fakultas Kedokteran' => [
                ['id_prodi' => 405, 'nama_prodi' => 'Kedokteran'],
            ],
            'Fakultas Seni Rupa dan Desain' => [
                ['id_prodi' => 615, 'nama_prodi' => 'Desain Interior'],
                ['id_prodi' => 625, 'nama_prodi' => 'Desain Komunikasi Visual'],
            ],
            'Fakultas Psikologi' => [
                ['id_prodi' => 705, 'nama_prodi' => 'Psikologi'],
            ],
            'Fakultas Teknologi Informasi' => [
                ['id_prodi' => 535, 'nama_prodi' => 'Teknik Informatika'],
                ['id_prodi' => 825, 'nama_prodi' => 'Sistem Informasi'],
            ],
            'Fakultas Ilmu Komunikasi' => [
                ['id_prodi' => 915, 'nama_prodi' => 'Ilmu Komunikasi'],
            ],
        ];

        foreach ($fakultasList as $namaFakultas => $prodiList) {
            $fakultas = Fakultas::create(['nama_fakultas' => $namaFakultas]);

            foreach ($prodiList as $prodi) {
                Prodi::create([
                    'id_prodi' => $prodi['id_prodi'],
                    'id_fakultas' => $fakultas->id_fakultas,
                    'nama_prodi' => $prodi['nama_prodi'],
                ]);
            }
        }
    }
}
