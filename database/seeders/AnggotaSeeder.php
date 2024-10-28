<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        // Data dummy untuk anggota
        $dataAnggota = [
            [
                'id_anggota' => '825210058',
                'id_prodi' => '825',
                'nama_anggota' => 'Rizera Dwi P',
                'email' => 'rizera@gmail.com',
                'password' => Hash::make('11111111'), // nama + tanggal lahir sebagai password default
                'no_hp' => '081234567890',
                'tanggal_lahir' => Carbon::create('1990', '01', '01'),
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'jenis_kelamin' => 'L',
                'foto_profil' => 'default.jpg',
            ],
            [
                'id_anggota' => '825210002',
                'id_prodi' => '825',
                'nama_anggota' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'password' => Hash::make('janesmith15051995'),
                'no_hp' => '081298765432',
                'tanggal_lahir' => Carbon::create('1995', '05', '15'),
                'alamat' => 'Jl. Kebon Jeruk No. 2, Bandung',
                'jenis_kelamin' => 'P',
                'foto_profil' => 'default.jpg',
            ],
            [
                'id_anggota' => '535210003',
                'id_prodi' => '535',
                'nama_anggota' => 'Robert Brown',
                'email' => 'robertbrown@example.com',
                'password' => Hash::make('robertbrown22071992'),
                'no_hp' => '081234123456',
                'tanggal_lahir' => Carbon::create('1992', '07', '22'),
                'alamat' => 'Jl. Raya No. 3, Surabaya',
                'jenis_kelamin' => 'L',
                'foto_profil' => 'default.jpg',
            ],
            [
                'id_anggota' => '705210004',
                'id_prodi' => '705',
                'nama_anggota' => 'Emily White',
                'email' => 'emilywhite@example.com',
                'password' => Hash::make('emilywhite01081993'),
                'no_hp' => '082134567890',
                'tanggal_lahir' => Carbon::create('1993', '08', '01'),
                'alamat' => 'Jl. Mawar No. 4, Malang',
                'jenis_kelamin' => 'P',
                'foto_profil' => 'default.jpg',
            ],
        ];

        // Insert data dummy ke dalam tabel anggota
        foreach ($dataAnggota as $data) {
            Anggota::create($data);
        }
    }
}
