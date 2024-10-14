<?php

namespace Database\Seeders;

use App\Enums\OrderType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkingDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Days of the week
        $days = [
            ['day' => 'Monday'],
            ['day' => 'Tuesday'],
            ['day' => 'Wednesday'],
            ['day' => 'Thursday'],
            ['day' => 'Friday'],
            ['day' => 'Saturday'],
            ['day' => 'Sunday'],
        ];

        $createCmsData = [];

        // Insert all days for Order Type 1 first
//        foreach ($days as $day) {
//            $createCmsData[] = [
//                'day' => $day['day'],
//                'order_type' => 1
//            ];
//        }

        // Insert all days for Order Type 2 next
        foreach ($days as $day) {
            $createCmsData[] = [
                'day' => $day['day'],
                'order_type' => 2
            ];
        }

        // Insert data into the database
        DB::table('restaurant_operating_hours')->insert($createCmsData);
    }
}
