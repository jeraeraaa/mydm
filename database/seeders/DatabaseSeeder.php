<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ProgramStudiSeeder::class,
            AnggotaSeeder::class,
            BphSeeder::class,
            KategoriKegiatanSeeder::class,
            KegiatanSeeder::class,
        ]);
    }
}
