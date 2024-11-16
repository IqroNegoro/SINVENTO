<?php

namespace App\Http\Controllers;

use App\Models\DetailSale;
use App\Models\Item;
use App\Models\Sale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CashierController extends Controller
{
    public function index() {
        return Inertia::render("cashier", [
            "items" => Item::all()
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "items" => "array|required|min:1",
            "items.*.id" => "required|exists:items,id",
            "items.*.stock" => "required|exists:items,stock",
            "items.*.qty" => [
                "required",
                "min:1",
                "integer",
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $index = explode(".", $attribute)[1];
                    $item = Item::find($request->input("items.$index.id"));
                    if ($item->stock < $value) {
                        $fail("Quantity exceed stock of $item->name product!");
                    }
                },
            ],
            "items.*.*" => "required"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        
        $data = $validator->validated();
        
        $data["total"] = array_reduce($data["items"], function($init, $value) {
            return $init += $value['sell_price'] * $value['qty'];
        }, 0);
        
        if ($sale = Sale::create($data)) {
            $data["items"] = array_map(function($value) use ($sale) {
                return [
                    "sale_id" => $sale->id,
                    "item_id" => $value["id"],
                    "qty" => $value["qty"],
                    "price" => $value["sell_price"],
                    "total" => $value["qty"] * $value["sell_price"]
                ];
            }, $data["items"]);
            collect($data["items"])->each(function ($item) {
                DetailSale::create($item);
            });
            return back()->with("success", "Purchase success, added to sales");
        }
        return back()->with("error", "Cannot add to sales, try again");
    }
}
