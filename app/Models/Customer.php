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
        return $this->hasMany(Sale::class, "customer_id", "code");
    } 
    
    public function scopeSort(Builder $query) {
        return $query->orderBy(request("sort") ?? "created_at", request("sort") ? "DESC" : "ASC");
    }

    public function scopeSearch(Builder $query) {
        $keyword = request("search");
        return $query->whereAny([
            "code",
            "name",
            "phone"
        ], "LIKE", "%$keyword%");
    }
}
