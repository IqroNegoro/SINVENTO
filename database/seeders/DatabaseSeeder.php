<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'admin',
        ]);

        Category::insert([
            [
            "code" => "C001",
            "name" => "Minyak",
            "user_id" => 1
            ],
            [
            "code" => "C002",
            "name" => "Beras",
            "user_id" => 1
            ]
        ]);

        Item::insert([
            [
            "category_id" => 1,
            "user_id" => 1,
            "name" => "Minyak Bimoli",
            "image" => "images/XoAHr2eft2JGlzb9zLgsL1BHRDPHlHOIUs7HWAsq.jpg",
            "stock" => 100,
            "buy_price" => 16000,
            "sell_price" => 20000
        ], [
            "category_id" => 2,
            "user_id" => 1,
            "name" => "Beras Super Sylph",
            "image" => "images\jpMupOwrJnxQaBnkxD4BOpX4zmw8Ff8iM6CjYHD8.jpg",
            "stock" => 100,
            "buy_price" => 250000,
            "sell_price" => 275000
        ]]);
    }
}
