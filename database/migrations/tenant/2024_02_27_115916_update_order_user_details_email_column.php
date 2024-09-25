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
        Schema::table('order_user_details', function (Blueprint $table) {
            $table->string('order_email')->nullable()->after('order_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_user_details', function (Blueprint $table) {
            $table->dropColumn('order_email');
        });
    }
};
