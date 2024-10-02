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
            // Adding the new status '7' for Cancelled
            $table->enum('order_status', [1, 2, 3, 4, 5, 6, 7])->nullable()->comment('1-Accepted, 2-In Kitchen, 3-Ready, 4-Ready for pickup(takeaway), 5-Out For Delivery, 6-Delivered, 7-Cancelled')->change();

            // Defaulting is_online_order to 1 (online)
            $table->boolean('is_online_order')->default(1)->comment('0 - Manual, 1 - Online')->after('order_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert the order_status enum to the original set of values (1-6)
            $table->enum('order_status', [1, 2, 3, 4, 5, 6])->nullable()->comment('1-Accepted, 2-In Kitchen, 3-Ready, 4-Ready for pickup(takeaway), 5-Out For Delivery, 6-Delivered')->change();
            // Remove the is_online_order column
            $table->dropColumn('is_online_order');
        });
    }
};
