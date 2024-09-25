<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_role', ['0', '1', '2'])->comment('1 - Restaurant, 0 - Users, 2 - Super admin')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_role', ['0', '1'])->comment('1 - Restaurant, 0 - Users')->change();
        });
    }
};
