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
        Schema::table('coupon_transactions', function (Blueprint $table) {
            $table->enum('is_redeemed',[1,0])->default('0')->comment('1-Redeemed, 0-Not redeemed')->after('coupon_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_transactions', function (Blueprint $table) {
            $table->dropColumn('is_redeemed');
        });
    }
};
