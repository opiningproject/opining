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
            $table->json('params')->nullable()->after('order_notif_sound'); // Change 'existing_column_name' to the column after which you want to add this
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_details', function (Blueprint $table) {
            $table->dropColumn('params');
        });
    }
};
