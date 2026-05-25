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
        Schema::create('tbl_detail_stock_opname', function (Blueprint $table) {

            $table->char('id_detail_stock_opname', 6)->primary();

            $table->char('id_stock_opname', 6);

            $table->char('id_barang', 6);

            $table->integer('stok_sistem');

            $table->integer('stok_fisik');

            $table->integer('selisih');

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('id_stock_opname')
                ->references('id_stock_opname')
                ->on('tbl_stock_opname')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('tbl_barang')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_detail_stock_opname');
    }
};
