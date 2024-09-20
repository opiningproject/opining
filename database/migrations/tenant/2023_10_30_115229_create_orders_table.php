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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('transaction_id')->nullable();
            $table->enum('payment_type', [1,2,3])->nullable()->comment('1-Card, 2-Cash, 3-Idle');
            $table->enum('payment_status', [0,1,2])->nullable()->comment('0-Pending, 1-Success, 2-Fail');
            $table->double('delivery_charge')->default(0);
            $table->double('platform_charge')->default(0);
            $table->double('total_amount')->default(0);
            $table->enum('order_status', [1,2,3,4,5,6])->nullable()->comment('1-Accepted, 2-In Kitchen, 3-Ready, 4-Ready for pickup(takeaway), 5-Out For Delivery, 6-Delivered');
            $table->enum('order_type', [1,2])->comment('1-Delivery, 2-Take Away');
            $table->datetime('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->string('delivery_note')->nullable();
            $table->enum('receive_update_emails', [1,0])->default(0)->comment('1-Yes, 0-No');
            $table->bigInteger('points')->default(0);
            $table->string('coupon_code')->nullable();
            $table->text('payment_response')->nullable();
            $table->enum('is_cart', [0,1])->default(0)->comment('1-In Cart, 0-Order Placed');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
