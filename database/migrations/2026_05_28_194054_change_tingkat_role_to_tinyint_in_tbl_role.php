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
        Schema::table('tbl_role', function (Blueprint $table) {
            $table->tinyInteger('tingkat_role')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_role', function (Blueprint $table) {
            $table->enum('tingkat_role', ['1', '2', '3', '4'])->change();
        });
    }
};
