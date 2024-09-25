<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
          /*   DatabaseSeeder::class, */
            //CategorySortOrderSeeder::class,
            CMSSeeder::class,
            //IngredientsCategorySortOrderSeeder::class,
            //IngredientsSortOrderSeeder::class,
          /*   RestaurantDetailSeeder::class, */
            WorkingDaysSeeder::class,
        ]);
    }
}
