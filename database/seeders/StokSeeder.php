<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 'user_id' dihapus karena tidak ada di migrasi
            // 'stok_jumlah' diubah menjadi 'jumlah'
            // 'stok_tanggal' diubah menjadi 'tanggal'
            // 'tipe' ditambahkan (wajib)
            // 'timestamps' ditambahkan (wajib)

            ['barang_id' => 1, 'jumlah' => 100, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 2, 'jumlah' => 150, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 3, 'jumlah' => 120, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 4, 'jumlah' => 50,  'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 5, 'jumlah' => 75,  'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 6, 'jumlah' => 200, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 7, 'jumlah' => 300, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 8, 'jumlah' => 100, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 9, 'jumlah' => 80,  'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 10, 'jumlah' => 250, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 11, 'jumlah' => 500, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 12, 'jumlah' => 400, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 13, 'jumlah' => 400, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 14, 'jumlah' => 150, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 15, 'jumlah' => 100, 'tipe' => 'masuk', 'tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('t_stok')->insert($data);
    }
}