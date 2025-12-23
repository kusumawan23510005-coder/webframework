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
            [
                'supplier_kode' => 'SUP1',           // <-- Tambahkan Kode
                'supplier_nama' => 'PT. Sumber Jaya', // <-- Sesuaikan Nama Kolom
                'supplier_alamat' => 'Malang',        // <-- Sesuaikan Nama Kolom
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP2',
                'supplier_nama' => 'CV. Maju Terus',
                'supplier_alamat' => 'Surabaya',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_kode' => 'SUP3',
                'supplier_nama' => 'Toko Barokah',
                'supplier_alamat' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('m_supplier')->insert($data);
    }
}
