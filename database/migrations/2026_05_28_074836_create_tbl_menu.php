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
        Schema::create('tbl_menu', function (Blueprint $table) {
            $table->char('id_menu', 6)->primary();

            $table->string('nama_menu', 100);

            $table->string('route_name', 100)->nullable();

            $table->string('icon', 100)->nullable();

            $table->integer('urutan')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_menu');
    }
};
