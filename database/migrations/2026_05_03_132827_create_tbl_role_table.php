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
        Schema::create('tbl_role', function (Blueprint $table) {
        $table->char('id_role', 6)->primary();
        $table->string('nama_role', 100)->nullable();
        $table->enum('tingkat_role', ['1', '2', '3']);
        $table->timestamps(); // created_at & updated_at
        $table->softDeletes(); // deleted_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_role');
    }
};
