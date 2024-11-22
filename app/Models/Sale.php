<?php

namespace App\Models;

use App\Models\DetailSale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sale extends Model
{
    public $guarded = [
        "id"
    ];

    protected $with = ["voucher", "detailSale"];

    public function detailSale() {
        return $this->hasMany(DetailSale::class);
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class);
    }

    public function scopeSort(Builder $query) {
        return $query->orderBy(request("sort") ?? "created_at", "DESC");
    }

    static public function boot() {
        parent::boot();

        static::created(function (Sale $sale) {
            if ($sale->voucher) {
                $sale->voucher->decrement("stock");
                $sale->voucher->increment("used");
            }
        });

        static::deleting(function (Sale $sale) {
            $sale->detailSale->each(function ($value) {
                $value->delete();
            });
        });
    }
}