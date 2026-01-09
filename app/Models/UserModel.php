<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING: Harus extend ini, bukan Model biasa
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // (Opsional: Jika nanti pakai JWT, tapi biarkan dulu)

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'm_user';        // Nama tabel di database
    protected $primaryKey = 'user_id';  // PENTING: Primary key Anda adalah user_id, bukan id

    protected $fillable = [
        'level_id',  // Pastikan form register mengirim level_id (atau diset default di controller)
        'username',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Fitur Laravel baru untuk otomatis hash password
    ];

    // Relasi ke tabel Level
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
