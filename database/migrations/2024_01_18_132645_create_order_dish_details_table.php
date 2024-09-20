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
        Schema::create('order_dish_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_detail_id');
            $table->unsignedBigInteger('dish_id');
            $table->unsignedBigInteger('dish_ingredient_id');
            $table->integer('quantity')->nullable();
            $table->double('price')->nullable();
            $table->double('total')->nullable();
            $table->enum('is_free', [1,0])->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->foreign('order_detail_id')->references('id')->on('order_details')->cascadeOnDelete();
            $table->foreign('dish_ingredient_id')->references('id')->on('dish_ingredients')->cascadeOnDelete();
            $table->foreign('dish_id')->references('id')->on('dishes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_dish_details');
    }
};
