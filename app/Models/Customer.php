<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [
        "id"
    ];

    public function sales() {
        return $this->hasMany(Sale::class);
    } 
    
    public function scopeSort(Builder $query) {
        return $query->orderBy(request("sort") ?? "created_at", "DESC");
    }

    public function scopeSearch(Builder $query) {
        $keyword = request("search");
        return $query->whereAny([
            "code",
            "name"
        ], "LIKE", "%$keyword%")->orWhere("visit", "<=", "$keyword")->orWhere("total", "<=", "$keyword");
    }
}
