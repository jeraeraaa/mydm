<?php

namespace Database\Seeders;

use App\Models\Inventaris;
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
            AlatSeeder::class,
            KetuaUmumSeeder::class,
            InventarisSeeder::class,
        ]);
    }
}
