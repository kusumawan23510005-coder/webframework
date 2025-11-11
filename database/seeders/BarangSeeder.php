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
            // --- SUPPLIER 1 (ID: 1) - 5 Barang ---
            [
                'kategori_id' => 1,
                'supplier_id' => 1,
                'kode_barang' => 'B001',   // <= DIUBAH
                'nama_barang' => 'Sereal Cokelat 150g', // <= DIUBAH
                'harga_beli' => 18000,
                'harga_jual' => 22000,
                'created_at' => now(), // Ditambahkan
                'updated_at' => now(), // Ditambahkan
            ],
            [
                'kategori_id' => 2,
                'supplier_id' => 1,
                'kode_barang' => 'B002',   // <= DIUBAH
                'nama_barang' => 'Kopi Bubuk 200g', // <= DIUBAH
                'harga_beli' => 25000,
                'harga_jual' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'supplier_id' => 1,
                'kode_barang' => 'B003',   // <= DIUBAH
                'nama_barang' => 'Tisu Wajah 250 sheet', // <= DIUBAH
                'harga_beli' => 16000,
                'harga_jual' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'supplier_id' => 1,
                'kode_barang' => 'B004',   // <= DIUBAH
                'nama_barang' => 'Sticky Notes (Set 3 warna)', // <= DIUBAH
                'harga_beli' => 9000,
                'harga_jual' => 12500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'supplier_id' => 1,
                'kode_barang' => 'B005',   // <= DIUBAH
                'nama_barang' => 'Lampu LED 10 Watt', // <= DIUBAH
                'harga_beli' => 30000,
                'harga_jual' => 40000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- SUPPLIER 2 (ID: 2) - 5 Barang ---
            [
                'kategori_id' => 1,
                'supplier_id' => 2,
                'kode_barang' => 'B006',   // <= DIUBAH
                'nama_barang' => 'Biskuit Krim Keju', // <= DIUBAH
                'harga_beli' => 8000,
                'harga_jual' => 11000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'supplier_id' => 2,
                'kode_barang' => 'B007',   // <= DIUBAH
                'nama_barang' => 'Teh Melati Celup', // <= DIUBAH
                'harga_beli' => 10000,
                'harga_jual' => 13000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'supplier_id' => 2,
                'kode_barang' => 'B008',   // <= DIUBAH
                'nama_barang' => 'Pengharum Ruangan Otomatis', // <= DIUBAH
                'harga_beli' => 45000,
                'harga_jual' => 55000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'supplier_id' => 2,
                'kode_barang' => 'B009',   // <= DIUBAH
                'nama_barang' => 'Cutter Kertas (Besar)', // <= DIUBAH
                'harga_beli' => 15000,
                'harga_jual' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'supplier_id' => 2,
                'kode_barang' => 'B010',   // <= DIUBAH
                'nama_barang' => 'Mouse Wireless', // <= DIUBAH
                'harga_beli' => 80000,
                'harga_jual' => 110000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- SUPPLIER 3 (ID: 3) - 5 Barang ---
            [
                'kategori_id' => 1,
                'supplier_id' => 3,
                'kode_barang' => 'B011',   // <= DIUBAH
                'nama_barang' => 'Saus Sambal 300ml', // <= DIUBAH
                'harga_beli' => 13000,
                'harga_jual' => 17000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'supplier_id' => 3,
                'kode_barang' => 'B012',   // <= DIUBAH
                'nama_barang' => 'Susu UHT Full Cream 1L', // <= DIUBAH
                'harga_beli' => 19000,
                'harga_jual' => 23000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'supplier_id' => 3,
                'kode_barang' => 'B013',   // <= DIUBAH
                'nama_barang' => 'Deterjen Bubuk 1kg', // <= DIUBAH
                'harga_beli' => 28000,
                'harga_jual' => 34000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'supplier_id' => 3,
                'kode_barang' => 'B014',   // <= DIUBAH
                'nama_barang' => 'Amplop Putih (Box 100)', // <= DIUBAH
                'harga_beli' => 22000,
                'harga_jual' => 28000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'supplier_id' => 3,
                'kode_barang' => 'B015',   // <= DIUBAH
                'nama_barang' => 'Stop Kontak 4 Lubang', // <= DIUBAH
                'harga_beli' => 55000,
                'harga_jual' => 70000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}