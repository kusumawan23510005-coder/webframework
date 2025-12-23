<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';

    // Pastikan kolom ini sesuai dengan migration kamu
    protected $fillable = ['supplier_kode', 'supplier_nama', 'supplier_alamat'];
}
