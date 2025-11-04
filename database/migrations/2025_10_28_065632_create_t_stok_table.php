<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->unsignedBigInteger('barang_id')->index();
            $table->integer('jumlah');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->date('tanggal');
            $table->timestamps();

            // Relasi ke barang
            $table->foreign('barang_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_stok');
    }
};
