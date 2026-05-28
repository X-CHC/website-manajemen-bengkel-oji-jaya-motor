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
        Schema::create('tbl_role_menu', function (Blueprint $table) {
            $table->char('id_role_menu', 6)->primary();

            $table->char('id_role', 6);

            $table->char('id_menu', 6);

            $table->boolean('can_access')->default(true);

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('id_role')
                ->references('id_role')
                ->on('tbl_role')
                ->onDelete('cascade');

            $table->foreign('id_menu')
                ->references('id_menu')
                ->on('tbl_menu')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_role_menu');
    }
};
