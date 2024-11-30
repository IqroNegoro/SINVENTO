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

    public function detailSale() {
        return $this->hasMany(DetailSale::class);
    }

    public function voucher() {
        return $this->belongsTo(Voucher::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class, "customer_id", "code");
    }

    public function scopeSort(Builder $query) {
        return $query->when(request("sort") == "customer", function(Builder $query, bool $value) {
            return $query->orderBy(Customer::select(["name"])->whereColumn("customers.code", "sales.customer_id"));
        }, function(Builder $query) {
            return $query->orderBy(request("sort") ?? "created_at");
        });
    }

    static public function boot() {
        parent::boot();

        static::created(function (Sale $sale) {
            if ($sale->voucher) {
                $sale->voucher->decrement("stock");
                $sale->voucher->increment("used");
            }

            if ($sale->customer) {
                $sale->customer->increment("total", $sale->total);
                $sale->customer->increment("visit");
            }
        });

        static::deleting(function (Sale $sale) {
            $sale->detailSale->each(function ($value) {
                $value->delete();
            });

            if ($sale->customer) {
                $sale->customer->decrement("total", $sale->total);
            }
        });
    }
}