<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::create([
            "code" => "P01",
            "name" => "Pengguna Baru",
            "description" => "Diskon untuk 100 orang pertama pelanggan baru!!!",
            "type" => "percentage",
            "value" => 50,
            "valid_from" => Carbon::today(),
            "valid_to" => Carbon::today()->addDays(7),
            "stock" => 100,
            "active" => true
        ]);
    }
}
