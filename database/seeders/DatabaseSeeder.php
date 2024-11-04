<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'admin',
        ]);

        $this->call([
            CategorySeeder::class,
            ItemSeeder::class,
            SaleSeeder::class,
            DetailSaleSeeder::class
        ]);
    }
}
