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
        Schema::create('tbl_barang_masuk', function (Blueprint $table) {
        $table->char('id_barang_masuk', 6)->primary();
        $table->char('id_po', 6)->nullable();
        $table->date('tanggal_masuk')->nullable();
        $table->integer('total_bayar')->nullable();
        $table->string('bukti_bayar', 255)->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('id_po')->references('id_po')->on('tbl_po')->onDelete('restrict');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_barang_masuk');
    }
};
