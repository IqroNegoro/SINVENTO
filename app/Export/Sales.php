<?php

namespace App\Export;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaleExport implements FromCollection
{
    public function collection()
    {
        return User::all();
    }
}