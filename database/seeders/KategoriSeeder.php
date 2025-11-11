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
            ['nama_kategori' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Pakaian', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Alat Tulis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Makanan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Minuman', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('m_kategori')->insert($data);
    }
}