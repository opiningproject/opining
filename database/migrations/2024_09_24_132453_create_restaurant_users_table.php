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
        Schema::create('restaurant_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('restaurant_name')->nullable();
            $table->string('permit_id')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('rest_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('online_order_accept', [0,1])->default(1)->comment('0-No, 1-Yes');
            $table->string('restaurant_logo')->nullable();
            $table->string('permit_doc')->nullable();
            $table->double('service_charge')->default(0);
            $table->string('delivery_time');
            $table->string('take_away_time');
            $table->enum('order_notif_sound', [0,1])->default(1)->comment('0-Off, 1-On');
            $table->json('params')->nullable();
            $table->integer('domain_id');
            $table->integer('new_restaurant_user_id')->comment("New restaurant user id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_users');
    }
};
