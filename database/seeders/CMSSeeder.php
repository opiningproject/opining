<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cms')->insert([
            'content' => 'Test Content',
            'lang' => 'en',
            'type' => 'privacy',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

        DB::table('cms')->insert([
            'content' => 'Test Content',
            'lang' => 'nl',
            'type' => 'privacy',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

        DB::table('cms')->insert([
            'content' => 'Test Content',
            'lang' => 'en',
            'type' => 'terms',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

        DB::table('cms')->insert([
            'content' => 'Test Content',
            'lang' => 'nl',
            'type' => 'terms',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

    }
}
