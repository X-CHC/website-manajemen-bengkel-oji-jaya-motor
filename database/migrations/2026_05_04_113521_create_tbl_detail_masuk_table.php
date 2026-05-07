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
        Schema::create('tbl_detail_masuk', function (Blueprint $table) {
        $table->char('id_detail_masuk', 6)->primary();
        $table->char('id_barang_masuk', 6)->nullable();
        $table->char('id_barang', 6)->nullable();
        $table->integer('jumlah_barang')->nullable();
        $table->integer('harga_beli');
        $table->integer('sub_total');
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('id_barang_masuk')->references('id_barang_masuk')->on('tbl_barang_masuk')->onDelete('cascade');
        $table->foreign('id_barang')->references('id_barang')->on('tbl_barang')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_detail_masuk');
    }
};
