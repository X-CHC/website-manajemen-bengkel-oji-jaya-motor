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
        Schema::table('tbl_barang_masuk', function (Blueprint $table) {
            $table->string('nota_supplier', 255)->nullable()->after('bukti_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_barang_masuk', function (Blueprint $table) {
            $table->dropColumn('nota_supplier');
        });
    }
};
