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
   /*      Schema::table('coupons', function (Blueprint $table) {
            $table->renameColumn('expiry_date', 'start_expiry_date');
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->date('end_expiry_date')->after('start_expiry_date')->nullable();
        }); */

        Schema::table('coupons', function (Blueprint $table) {
            $table->renameColumn('expiry_date', 'start_expiry_date');
            $table->date('end_expiry_date')->after('start_expiry_date')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->renameColumn('start_expiry_date', 'expiry_date');
            $table->dropColumn('end_expiry_date');
        });
    }
};
