<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Sesuaikan nama kolom dengan migrasi
            [
                'nama_supplier' => 'PT. Sumber Jaya', // <- DIUBAH
                'alamat' => 'Malang',                 // <- DIUBAH
                'created_at' => now(),
                'updated_at' => now()                 // <- DITAMBAHKAN
            ],
            [
                'nama_supplier' => 'CV. Maju Terus',  // <- DIUBAH
                'alamat' => 'Surabaya',               // <- DIUBAH
                'created_at' => now(),
                'updated_at' => now()                 // <- DITAMBAHKAN
            ],
            [
                'nama_supplier' => 'Toko Barokah',    // <- DIUBAH
                'alamat' => 'Jakarta',                // <- DIUBAH
                'created_at' => now(),
                'updated_at' => now()                 // <- DITAMBAHKAN
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}