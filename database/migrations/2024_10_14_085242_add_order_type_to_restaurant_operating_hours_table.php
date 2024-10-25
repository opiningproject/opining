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
        Schema::table('restaurant_operating_hours', function (Blueprint $table) {
            $table->enum('order_type', [1,2])->comment('1-Delivery, 2-Take Away')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_operating_hours', function (Blueprint $table) {
            $table->dropColumn('order_type');
        });
    }
};
