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
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger( 'points_redeemed')->nullable()->after('coupon_discount');
            $table->bigInteger('points_claimed')->nullable()->after('points_redeemed');
            $table->dropColumn('coupon_points');
            $table->dropColumn('points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('coupon_points');
            $table->bigInteger('points');
        });
    }
};
