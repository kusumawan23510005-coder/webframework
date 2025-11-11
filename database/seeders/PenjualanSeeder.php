<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 10 transaksi, oleh user_id 3 (Kasir)
            // Sesuaikan dengan nama kolom di migrasi
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), // <- DIUBAH
                'total_harga' => 150000,       // <- DITAMBAHKAN
                'created_at' => now(),         // <- DITAMBAHKAN
                'updated_at' => now()          // <- DITAMBAHKAN
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 250000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 75000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 320000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 120000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 50000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 90000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 185000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 450000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'user_id' => 3, 
                'tanggal_penjualan' => now(), 
                'total_harga' => 110000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}