<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("vouchers/index", [
            "vouchers" => Voucher::search()->sort()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("vouchers/add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        if (Voucher::create($request->validated())) {
            return redirect()->route('vouchers.index')->with("success", "Voucher has been added");
        }

        return back()->with("error", "Cannot create voucher, try again");
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        return Inertia::render("vouchers/edit", [
            "voucher" => $voucher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        if ($voucher->update($request->validated())) {
            return to_route("vouchers.index")->with("success", "Success update $voucher->name voucher");
        }

        return back()->with("error", "Cannot update voucher $voucher->name, try again");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        if ($voucher->delete()) {
            return back()->with("success", "Voucher $voucher->name removed");
        }

        return back()->with("error", "Cannot removed $voucher->name voucher");
    }
}
