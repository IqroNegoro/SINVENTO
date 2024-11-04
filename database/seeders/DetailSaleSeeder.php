<?php

namespace Database\Seeders;

use App\Models\DetailSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailSale::insert([
            [
              "sale_id" => 1,
              "item_id" => 2,
              "qty" => 1,
              "price" => 275000,
              "total" => 275000
            ],
            [
              "sale_id" => 1,
              "item_id" => 1,
              "qty" => 2,
              "price" => 20000,
              "total" => 40000
            ],
            [
              "sale_id" => 2,
              "item_id" => 2,
              "qty" => 1,
              "price" => 275000,
              "total" => 275000
            ],
            [
              "sale_id" => 3,
              "item_id" => 2,
              "qty" => 2,
              "price" => 275000,
              "total" => 550000
            ],
            [
              "sale_id" => 3,
              "item_id" => 1,
              "qty" => 8,
              "price" => 20000,
              "total" => 160000
            ],
            [
              "sale_id" => 4,
              "item_id" => 1,
              "qty" => 1,
              "price" => 20000,
              "total" => 20000
            ],
        ]);
    }
}
