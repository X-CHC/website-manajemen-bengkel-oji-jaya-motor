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
        Schema::create('tbl_detail_po', function (Blueprint $table) {
        $table->char('id_detail_po', 6)->primary();
        $table->char('id_po', 6)->nullable();
        $table->char('id_barang', 6)->nullable();
        $table->integer('jumlah_po')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('id_po')->references('id_po')->on('tbl_transaksi_po')->onDelete('cascade');
        $table->foreign('id_barang')->references('id_barang')->on('tbl_barang')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_detail_po');
    }
};
