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
      /*   Schema::table('coupons', function (Blueprint $table) {
            // Check if the column 'expiry_date' exists before renaming
            if (Schema::hasColumn('coupons', 'expiry_date')) {
                $table->renameColumn('expiry_date', 'start_expiry_date');
            }

            // Add 'end_expiry_date' column after 'start_expiry_date'
            if (!Schema::hasColumn('coupons', 'end_expiry_date')) {
                $table->date('end_expiry_date')->after('start_expiry_date')->nullable();
            }
        }); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Rename 'start_expiry_date' back to 'expiry_date'
            if (Schema::hasColumn('coupons', 'start_expiry_date')) {
                $table->renameColumn('start_expiry_date', 'expiry_date');
            }

            // Drop 'end_expiry_date' column
            if (Schema::hasColumn('coupons', 'end_expiry_date')) {
                $table->dropColumn('end_expiry_date');
            }
        });
    }
};
