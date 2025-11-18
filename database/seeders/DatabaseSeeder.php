<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder data master terlebih dahulu
        $this->call([
            LevelSeeder::class,
            KategoriSeeder::class,
            SupplierSeeder::class,
        ]);

        // Panggil seeder yang bergantung pada data master
        $this->call([
            UserSeeder::class,
            BarangSeeder::class,
        ]);

        // Panggil seeder yang bergantung pada data barang/user
        $this->call([
            StokSeeder::class,
            PenjualanSeeder::class,
        ]);
        
        // Panggil seeder detail di paling akhir
        $this->call([
            PenjualanDetailSeeder::class,
        ]);
    }
}