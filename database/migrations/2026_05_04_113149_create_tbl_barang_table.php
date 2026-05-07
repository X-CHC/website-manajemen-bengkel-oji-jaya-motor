<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_barang', function (Blueprint $table) {
        $table->char('id_barang', 6)->primary();
        $table->char('id_kategori_barang', 6)->nullable();
        $table->string('nama_barang', 255)->nullable();
        $table->integer('harga_beli')->nullable();
        $table->integer('harga_jual');
        $table->integer('jumlah_barang')->nullable();
        $table->integer('alert_jumlah_barang')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('id_kategori_barang')->references('id_kategori_barang')->on('tbl_kategori_barang')->onDelete('restrict');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_barang');
    }
};
