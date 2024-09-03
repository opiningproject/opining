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
        Schema::table('dish_categories_options', function (Blueprint $table) {
            $table->string('price')->nullable()->after('name_nl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dish_categories_options', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
