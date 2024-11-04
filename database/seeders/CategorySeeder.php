<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            ],
            [
                "code" => "C003",
                "name" => "Telur",
                "user_id" => 1
            ]
        ]);
    }
}
