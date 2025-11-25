<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Jangan lupa

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Sesuaikan dengan nama kolom di migrasi
            // ↓↓↓ Kolom 'kategori_kode' ditambahkan ↓↓↓
            [
                'kategori_kode' => 'ELK',
                'kategori_nama' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_kode' => 'PKN',
                'kategori_nama' => 'Pakaian',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_kode' => 'ALT',
                'kategori_nama' => 'Alat Tulis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_kode' => 'MKN',
                'kategori_nama' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kategori_kode' => 'MNM',
                'kategori_nama' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}