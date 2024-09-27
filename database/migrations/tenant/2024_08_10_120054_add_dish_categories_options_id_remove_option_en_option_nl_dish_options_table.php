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
        Schema::table('dish_options', function (Blueprint $table) {
            $table->unsignedBigInteger('dish_category_options_id')->after('id');
            $table->foreign('dish_category_options_id')->references('id')->on('dish_categories_options')->cascadeOnDelete();
            $table->dropColumn('option_en');
            $table->dropColumn('option_nl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dish_options', function (Blueprint $table) {
            $table->dropColumn('categories_options_id');

            // Re-add the removed column (you can change the type as per your requirement)
            $table->string('option_en_option_nl')->nullable()->after('id');
        });
    }
};
