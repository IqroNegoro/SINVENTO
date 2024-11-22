<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            "code" => "C001",
            "name" => "Najib",
            "phone" => "08912345678",
            "visit" => 1,
            "total" => 315000
        ]);
    }
}
