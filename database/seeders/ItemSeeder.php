<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::insert([
            [
                "category_id" => 1,
                "user_id" => 1,
                "name" => "Minyak Bimoli",
                "image" => "images/XoAHr2eft2JGlzb9zLgsL1BHRDPHlHOIUs7HWAsq.jpg",
                "stock" => 100,
                "buy_price" => 16000,
                "sell_price" => 20000
            ],
            [
                "category_id" => 2,
                "user_id" => 1,
                "name" => "Beras Super Sylph",
                "image" => "images\jpMupOwrJnxQaBnkxD4BOpX4zmw8Ff8iM6CjYHD8.jpg",
                "stock" => 100,
                "buy_price" => 250000,
                "sell_price" => 275000
            ],
            [
                "category_id" => 3,
                "user_id" => 1,
                "name" => "Telur",
                "image" => "images\jvv9eL7CT0se1JOLAZCHkVWWd2sK7WVifuX88B.jpg",
                "stock" => 150,
                "buy_price" => 20000,
                "sell_price" => 23000
            ],
        ]);
    }
}
