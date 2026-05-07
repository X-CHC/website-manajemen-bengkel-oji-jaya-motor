<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_user', function (Blueprint $table) {
            $table->renameColumn('username', 'email');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_user', function (Blueprint $table) {
            $table->renameColumn('email', 'username');
        });
    }
};
