<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkingDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createCmsData = [
            ['day'=>'Monday'],
            ['day'=>'Tuesday'],
            ['day'=>'Wednesday'],
            ['day'=>'Thursday'],
            ['day'=>'Friday'],
            ['day'=>'Saturday'],
            ['day'=>'Sunday'],
        ];

        DB::table('operating_hours')->insert($createCmsData);
    }
}
