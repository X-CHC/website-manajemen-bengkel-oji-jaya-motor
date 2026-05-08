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
        Schema::create('tbl_history_stok', function (Blueprint $table) {
        $table->char('id_history_stok', 6)->primary();
        $table->char('id_barang', 6)->nullable();
        $table->integer('jumlah_masuk');
        $table->integer('jumlah_keluar');
        $table->integer('jumlah_sisa');
        $table->integer('jumlah_barang')->nullable();
        $table->timestamps(); // Menggantikan kolom 'updated' manual sebelumnya
        $table->softDeletes();

        $table->foreign('id_barang')->references('id_barang')->on('tbl_barang')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_history_stok');
    }
};
