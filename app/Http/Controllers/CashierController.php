<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierPostRequest;
use App\Models\DetailSale;
use App\Models\Item;
use App\Models\Sale;
use App\Models\Voucher;
use Carbon\Carbon;
use Inertia\Inertia;

class CashierController extends Controller
{
    public function index()
    {
        return Inertia::render("cashier", [
            "items" => Item::all(),
            "vouchers" => Voucher::active()->available()->get()
        ]);
    }

    public function store(CashierPostRequest $request)
    {
        $request->validated();

        $request["subtotal"] = array_reduce($request->items, function ($init, $value) {
            return $init += $value['sell_price'] * $value['qty'];
        }, 0);

        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher || !$voucher->active || $voucher->valid_from->greaterThan(Carbon::today()) || $voucher->valid_to->lessThan(Carbon::today()) || (!is_null($voucher->stock) && $voucher->stock == 0)) {
            $voucher = null;
        }

        $request["total"] = $voucher ? $request->subtotal - ($voucher->type == 'fixed' ? $voucher->value : $request->subtotal * $voucher->value / 100) : $request->subtotal;

        if ($sale = Sale::create($request->all())) {
            foreach ($request->items as $item) {
                DetailSale::create([
                    "sale_id" => $sale->id,
                    "item_id" => $item["id"],
                    "qty" => $item["qty"],
                    "price" => $item["sell_price"],
                    "total" => $item["qty"] * $item["sell_price"]
                ]);
            }

            return back()->with("success", "Purchase success, added to sales");
        }
        return back()->with("error", "Cannot add to sales, try again");
    }
}
