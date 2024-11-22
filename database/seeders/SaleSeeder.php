<?php

namespace Database\Seeders;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::insert([
            [
                "customer_id" => "C001",
                "subtotal" => 315000,
                "total" => 315000,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "customer_id" => null,
                "subtotal" => 275000,
                "total" => 275000,
                "created_at" =>  Carbon::now()->subDay(),
                "updated_at" => Carbon::now()->subDay()
            ],
            [
                "customer_id" => null,
                "subtotal" => 710000,
                "total" => 710000,
                "created_at" =>  Carbon::now()->subDays(2),
                "updated_at" => Carbon::now()->subDays(2)
            ],
            [
                "customer_id" => null,
                "subtotal" => 20000,
                "total" => 20000,
                "created_at" =>  Carbon::now()->subDays(3),
                "updated_at" => Carbon::now()->subDays(3)
            ],
        ]);
    }
}
