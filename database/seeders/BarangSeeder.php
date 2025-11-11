<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'kategori_id' => 1,
                'supplier_id' => 1,
                'kode_barang' => 'B001',   
                'nama_barang' => 'Sereal Cokelat 150g', 
                'harga_beli' => 18000,
                'harga_jual' => 22000,
                'created_at' => now(), 
                'updated_at' => now(), 
            ],
            [
                'kategori_id' => 2,
                'supplier_id' => 1,
                'kode_barang' => 'B002',   
                'nama_barang' => 'Kopi Bubuk 200g', 
                'harga_beli' => 25000,
                'harga_jual' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'supplier_id' => 1,
                'kode_barang' => 'B003',   
                'nama_barang' => 'Tisu Wajah 250 sheet', 
                'harga_beli' => 16000,
                'harga_jual' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'supplier_id' => 1,
                'kode_barang' => 'B004',
                'nama_barang' => 'Sticky Notes (Set 3 warana)',
                'harga_beli' => 9000,
                'harga_jual' => 12500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'supplier_id' => 1,
                'kode_barang' => 'B005',   
                'nama_barang' => 'Lampu LED 10 Watt', 
                'harga_beli' => 30000,
                'harga_jual' => 40000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- SUPPLIER 2 (ID: 2) - 5 Barang ---
            [
                'kategori_id' => 1,
                'supplier_id' => 2,
                'kode_barang' => 'B006',   
                'nama_barang' => 'Biskuit Krim Keju', 
                'harga_beli' => 8000,
                'harga_jual' => 11000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'supplier_id' => 2,
                'kode_barang' => 'B007',   
                'nama_barang' => 'Teh Melati Celup', 
                'harga_beli' => 10000,
                'harga_jual' => 13000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'supplier_id' => 2,
                'kode_barang' => 'B008',   
                'nama_barang' => 'Pengharum Ruangan Otomatis', 
                'harga_beli' => 45000,
                'harga_jual' => 55000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'supplier_id' => 2,
                'kode_barang' => 'B009',   
                'nama_barang' => 'Cutter Kertas (Besar)', 
                'harga_beli' => 15000,
                'harga_jual' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'supplier_id' => 2,
                'kode_barang' => 'B010',   
                'nama_barang' => 'Mouse Wireless', 
                'harga_beli' => 80000,
                'harga_jual' => 110000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- SUPPLIER 3 (ID: 3) - 5 Barang ---
            [
                'kategori_id' => 1,
                'supplier_id' => 3,
                'kode_barang' => 'B011',   
                'nama_barang' => 'Saus Sambal 300ml', 
                'harga_beli' => 13000,
                'harga_jual' => 17000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'supplier_id' => 3,
                'kode_barang' => 'B012',   
                'nama_barang' => 'Susu UHT Full Cream 1L', 
                'harga_beli' => 19000,
                'harga_jual' => 23000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'supplier_id' => 3,
                'kode_barang' => 'B013',   
                'nama_barang' => 'Deterjen Bubuk 1kg', 
                'harga_beli' => 28000,
                'harga_jual' => 34000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'supplier_id' => 3,
                'kode_barang' => 'B014',
                'nama_barang' => 'Amplop Putih',
                'harga_beli' => 22000,
                'harga_jual' => 28000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'supplier_id' => 3,
                'kode_barang' => 'B015',
                'nama_barang' => 'Stop Kontak 4 Lubang',
                'harga_beli' => 55000,
                'harga_jual' => 70000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}