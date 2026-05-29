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
        Schema::table('tbl_transaksi', function (Blueprint $table) {

            $table->char('id_user', 6)
                ->nullable()
                ->after('id_transaksi');

            $table->foreign('id_user')
                ->references('id_user')
                ->on('tbl_user')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_transaksi', function (Blueprint $table) {

            $table->dropForeign(['id_user']);

            $table->dropColumn('id_user');
        });
    }
};
