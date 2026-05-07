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
        Schema::create('tbl_user', function (Blueprint $table) {
        $table->char('id_user', 6)->primary();
        $table->char('id_role', 6)->nullable();

        $table->string('username', 100)->unique(); // jangan nullable kalau dipakai login
        $table->string('password'); // tidak perlu nullable

        $table->timestamps();
        $table->softDeletes();

        $table->foreign('id_role')
            ->references('id_role')
            ->on('tbl_role')
            ->onDelete('restrict');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user');
    }
};
