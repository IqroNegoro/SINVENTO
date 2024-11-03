<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("sales/index", [
            "sales" => Sale::sort()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return Inertia::render("sales/show", [
            "sale" => $sale
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if ($sale->delete()) {
            return back()->with("success", "Success delete record");
        }
        return back()->with("error", "Error delete record, try again");
    }

    public function report(Request $request) {
        $request->validate([
            "date" => "required|array"
        ]);

        $sale = Sale::whereBetween("created_at", $request->date)->get(["total", "created_at"]);

        $pdf = PDF::loadView('report', [
            "sales" => $sale,
            "total" => $sale->sum("total"),
            "dates" => [Carbon::createFromDate($request->date[0])->locale("id-ID")->getTranslatedMonthName(), Carbon::createFromDate($request->date[1])->locale("id-ID")->getTranslatedMonthName(), Carbon::createFromDate($request->date[1])->year]
        ])->setPaper("A4");

        return $pdf->stream('report.pdf');
    }
}
