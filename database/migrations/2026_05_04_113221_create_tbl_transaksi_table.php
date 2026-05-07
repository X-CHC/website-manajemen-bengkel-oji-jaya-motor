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
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            $table->char('id_transaksi', 6)->primary();
            $table->char('id_pelanggan', 6)->nullable();
            $table->char('nama_pelanggan_lain', 100);
            $table->date('tanggal_transaksi')->nullable();
            $table->integer('total_harga')->nullable();
            $table->integer('harga_jasa')->nullable();
            $table->integer('uang_bayar');
            $table->integer('uang_kembali');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('tbl_pelanggan')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi');
    }
};
