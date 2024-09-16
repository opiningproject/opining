<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientsSortOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients=Ingredient::orderBy("created_at","desc")->get();

        $order=1;

        foreach ($ingredients as $ingredient) {
            $ingredient->sort_order = $order;
            $ingredient->save();
            $order++;
        }    
    }
}
