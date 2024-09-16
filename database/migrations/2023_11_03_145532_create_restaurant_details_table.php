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
        Schema::create('restaurant_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
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
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_details');
    }
};
