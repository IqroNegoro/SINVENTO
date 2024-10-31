<?php

namespace App\Http\Controllers;

use App\Models\DetailSale;
use App\Models\Item;
use App\Models\Sale;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        // dd();
        return Inertia::render("index", [
            "total_revenue" => Sale::whereDate('created_at', Carbon::today())->get()->sum("total"),
            "total_items" => Item::all()->count(),
            "total_orders" => Sale::all()->count(),
            "recent_orders" => DetailSale::limit(5)->get(),
            "charts" => Sale::whereMonth("created_at", Carbon::now()->month)->get(["created_at", "total"])->map(function ($value) {
                return [$value->created_at->toDateTimeString(), $value->total];
            })
        ]);
    }
}
