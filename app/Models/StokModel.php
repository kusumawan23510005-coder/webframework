<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 't_stok';

    // Mendefinisikan primary key (karena default Laravel adalah 'id')
    protected $primaryKey = 'stok_id';

    // Kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    // Sesuai dengan kolom di phpMyAdmin Anda
    protected $fillable = [
        'barang_id',
        'jumlah',
        'tipe',
        'tanggal'
    ];

    /**
     * Mendefinisikan relasi ke model Barang.
     * Stok 'belongsTo' (milik) Barang.
     */
    public function barang(): BelongsTo
    {
        // Parameter: Model Tujuan, Foreign Key di t_stok, Primary Key di m_barang
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
}
