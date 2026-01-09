<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';

    protected $fillable = [
        'user_id',
        'pembeli',         // Sesuai diskusi awal (opsional jika ada di DB)
        'penjualan_kode',  // Sesuai diskusi awal (opsional jika ada di DB)
        'tanggal_penjualan', // PENTING: Sesuai data Anda
        'total_harga'        // PENTING: Sesuai data Anda
    ];

    // Relasi ke User (Kasir)
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    // Relasi ke Detail Barang
    public function details()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }
}
