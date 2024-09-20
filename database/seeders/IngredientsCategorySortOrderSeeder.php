<?php

namespace Database\Seeders;

use App\Models\IngredientCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientsCategorySortOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = IngredientCategory::orderBy('created_at', 'desc')->get();

        $order = 1;
        foreach ($categories as $category) {
            $category->sort_order = $order;
            $category->save();
            $order++;
        }

    }
}
