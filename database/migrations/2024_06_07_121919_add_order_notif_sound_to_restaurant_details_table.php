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
        Schema::table('restaurant_details', function (Blueprint $table) {
            $table->enum('order_notif_sound', [0,1])->default(1)->comment('0-Off, 1-On')->after('service_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_details', function (Blueprint $table) {
            $table->dropColumn('order_notif_sound');
        });
    }
};
