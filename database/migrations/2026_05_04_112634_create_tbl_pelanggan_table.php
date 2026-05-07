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
        Schema::create('tbl_pelanggan', function (Blueprint $table) {
        $table->char('id_pelanggan', 6)->primary();
        $table->string('nama_pelanggan', 255)->nullable();
        $table->string('plat_nomor', 50)->nullable();
        $table->string('merek_motor', 100)->nullable();
        $table->string('warna_motor', 50)->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pelanggan');
    }
};
