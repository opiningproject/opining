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
        Schema::table('dish_options_categories', function (Blueprint $table) {
            $table->string('title_en')->after('name_nl');
            $table->string('title_nl')->after('title_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dish_options_categories', function (Blueprint $table) {
            $table->dropColumn('title_en');
            $table->dropColumn('title_nl');
        });
    }
};
