<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Voucher extends Model
{
    protected $guarded = [
        "id"
    ];

    protected function casts() : array {
        return [
            'valid_from' => 'date:Y/m/d',
            'valid_to' => 'date:Y/m/d'
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function scopeSort(Builder $query)
    {
        return $query->orderBy(request("sort") ?? "created_at");
    }

    public function scopeSearch(Builder $query)
    {
        $keyword = request("search");
        return $query->whereAny([
            "code",
            "name",
            "description",
            "value_type",
            "type",
            "value"
        ], "LIKE", "%$keyword%")->orWhere("stock", "<=", "$keyword");
    }
}
