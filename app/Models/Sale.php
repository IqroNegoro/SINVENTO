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

    protected $with = ["detailSale"];

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

        // static::creating(function (Sale $sale) {
        //     if (!$sale->user_id) {
        //         $sale->user_id = Auth::id();
        //     }
        // });

        static::deleting(function (Sale $sale) {
            $sale->detailSale->each(function ($value) {
                $value->delete();
            });
        });
    }
}