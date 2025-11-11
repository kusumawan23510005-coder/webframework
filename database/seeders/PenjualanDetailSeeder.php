<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        
        // Loop 10 transaksi (sesuai PenjualanSeeder)
        for ($i = 1; $i <= 10; $i++) {
            
            // 3 barang per transaksi (total 30)
            $data[] = [
                'penjualan_id' => $i, 
                'barang_id' => 1, 
                'jumlah' => 1, 
                'harga_jual' => 7000000,         // <- DIUBAH
                'subtotal' => 1 * 7000000,       // <- DITAMBAHKAN
                'created_at' => now(),           // <- DITAMBAHKAN
                'updated_at' => now()            // <- DITAMBAHKAN
            ];
            
            $data[] = [
                'penjualan_id' => $i, 
                'barang_id' => 5, 
                'jumlah' => 5, 
                'harga_jual' => 3000,            // <- DIUBAH
                'subtotal' => 5 * 3000,          // <- DITAMBAHKAN
                'created_at' => now(),           // <- DITAMBAHKAN
                'updated_at' => now()            // <- DITAMBAHKAN
            ];
            
            $data[] = [
                'penjualan_id' => $i, 
                'barang_id' => 8, 
                'jumlah' => 2, 
                'harga_jual' => 3500,            // <- DIUBAH
                'subtotal' => 2 * 3500,          // <- DITAMBAHKAN
                'created_at' => now(),           // <- DITAMBAHKAN
                'updated_at' => now()            // <- DITAMBAHKAN
            ];
        }
        
        DB::table('t_penjualan_detail')->insert($data);
    }
}