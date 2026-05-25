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
        Schema::create('tbl_stock_opname', function (Blueprint $table) {

            $table->char('id_stock_opname', 6)->primary();

            $table->char('id_user', 6)->nullable();

            $table->date('tanggal_opname');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('tbl_user')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stock_opname');
    }
};
