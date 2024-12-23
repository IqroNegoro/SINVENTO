<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("sales/index", [
            "sales" => Sale::with("customer")->sort()->paginate(10)
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
            "sale" => $sale->load("voucher:id,value,type", "detailSale", "customer:id,code,name")
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

    public function pdf()
    {
        request()->validate([
            "startDate" => "required|date",
            "endDate" => "required|date",
        ]);

        $sale = Sale::whereBetween("created_at", [request("startDate"), request("endDate")])->orderBy("created_at", "ASC")->get(["total", "created_at"]);

        $pdf = PDF::loadView('pdf', [
            "sales" => $sale,
            "total" => $sale->sum("total"),
            "dates" => [Carbon::createFromDate(request("startDate"))->locale("id-ID")->getTranslatedMonthName(), Carbon::createFromDate(request("endDate"))->locale("id-ID")->getTranslatedMonthName(), Carbon::createFromDate(request("endDate"))->year]
        ])->setPaper("A4");

        $startDate = Carbon::parse(request('startDate'))->locale('id-ID');
        $endDate = Carbon::parse(request('endDate'))->locale('id-ID');
        $filename = "Sales report " . $startDate->getTranslatedMonthName();
        if ($startDate->getTranslatedMonthName() !== $endDate->getTranslatedMonthName()) {
            $filename .= " - " . $endDate->getTranslatedMonthName(); 
        }
        $filename .= $endDate->year;
        return $pdf->stream($filename . '.pdf');
    }

    public function excel()
    {
        request()->validate([
            "startDate" => "required|date",
            "endDate" => "required|date",
        ]);

        $startDate = Carbon::parse(request('startDate'))->locale('id-ID');
        $endDate = Carbon::parse(request('endDate'))->locale('id-ID');
        $filename = "Sales report " . $startDate->getTranslatedMonthName();
        if ($startDate->getTranslatedMonthName() !== $endDate->getTranslatedMonthName()) {
            $filename .= " - " . $endDate->getTranslatedMonthName();
        }
        $filename .= $endDate->year;

        return Excel::download(new SalesExport(request("startDate"), request("endDate")), $filename . ".xlsx");
    }
}
