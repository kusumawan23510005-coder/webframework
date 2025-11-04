<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->unsignedBigInteger('kategori_id')->index();
            $table->unsignedBigInteger('supplier_id')->index();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 100);
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);
            $table->timestamps();

            // Relasi ke kategori dan supplier
            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
