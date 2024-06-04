<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySortOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::orderBy('created_at', 'desc')->get();

        $order = 1;
        foreach ($categories as $category) {
            $category->sort_order = $order;
            $category->save();
            $order++;
        }
    }
}
