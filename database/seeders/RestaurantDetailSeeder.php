<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('restaurant_details')->insert([
            'user_id' => 1,
            'restaurant_name' => 'Restaurant Name',
            'permit_id' => '123',
            'phone_no' => '123',
            'rest_address' => '123',
            'online_order_accept' => '1',
            'service_charge' => '0',
            'params' => json_encode([
                "payment_settings" => [
                    "ideal" => 1,
                    "card" => 1,
                    "cod" => 1
                ],
                "order_settings" => [
                    "end_date"=> null,
                    "start_date"=> null,
                    "expiry_date" => null,
                    "timezone_setting" => null,
                    "order_setting_type" => null
                ],
                "display_order_settings" => [
                    "time_orders_top" => "0",
                    "display_red_color" => "0",
                ]
            ]),
            'delivery_time' => '20-45 Min',
            'take_away_time' => '10-15 Min',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
    }
}
