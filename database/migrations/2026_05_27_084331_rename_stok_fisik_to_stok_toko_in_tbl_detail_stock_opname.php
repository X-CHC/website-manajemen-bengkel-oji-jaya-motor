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
        Schema::table('tbl_detail_stock_opname', function (Blueprint $table) {
            // Mengubah nama kolom dari 'stok_fisik' menjadi 'stok_toko'
            $table->renameColumn('stok_fisik', 'stok_toko');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_detail_stock_opname', function (Blueprint $table) {
            // Mengembalikan nama kolom ke asalnya jika di-rollback
            $table->renameColumn('stok_toko', 'stok_fisik');
        });
    }
};
