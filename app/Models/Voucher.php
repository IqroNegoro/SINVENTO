<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Voucher extends Model
{
    protected $guarded = [
        "id"
    ];

    protected $appends = [
        "valid_from_formatted",
        "valid_to_formatted"
    ];

    public function getValidFromFormattedAttribute()
    {
        return $this->valid_from ? Carbon::parse($this->valid_from)->format('Y/m/d') : null;
    }

    public function getValidToFormattedAttribute()
    {
        return $this->valid_to ? Carbon::parse($this->valid_to)->format('Y/m/d') : null;
    }
    
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where("stock", ">", 0)->orWhereNull("stock");
    }

    public function scopeActive(Builder $query)
    {
        return $query->where("valid_from", "<=", Carbon::today()->toDateString())->where("valid_to", ">=", Carbon::today()->toDateString())->whereActive(true);
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
            "type",
            "type",
            "value"
        ], "LIKE", "%$keyword%")->orWhere("stock", "<=", "$keyword");
    }
}
