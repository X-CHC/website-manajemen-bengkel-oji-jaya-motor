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
        Schema::create('tbl_user_menu', function (Blueprint $table) {
            $table->char('id_user_menu', 6)->primary();

            $table->char('id_user', 6);

            $table->char('id_menu', 6);

            $table->boolean('can_access')->default(true);

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('tbl_user')
                ->onDelete('cascade');

            $table->foreign('id_menu')
                ->references('id_menu')
                ->on('tbl_menu')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_user_menu');
    }
};
