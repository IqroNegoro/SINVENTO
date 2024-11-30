<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Exception;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("customers/index", [
            "customers" => Customer::search()->sort()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("customers/add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        if (Customer::create($request->validated())) {
            return to_route("customers.index")->with("success", "Success added new customer");
        }
        return back()->with("error", "Cannot add new customer, try again");
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return Inertia::render("customers/show", [
            "customer" => $customer,
            "sales" => $customer->sales()->paginate(10)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return Inertia::render("customers/edit", [
            "customer" => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if ($customer->update($request->validated())) {
            return to_route("customers.index")->with("success", "Success update customer $customer->name");
        }
        return back()->with("error", "Cannot update customer, try again");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            if ($customer->delete()) {
                return back()->with("success", "Success delete customer $customer->name");
            }
            return back()->with("error", "Error delete customer $customer->name");
        } catch (Exception $e) {
            return back()->with("error", "Error delete customer $customer->name");
        }
    }
}
