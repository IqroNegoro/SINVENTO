<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render("index");
});

Route::middleware("guest")->group(function() {
    Route::get("/login", [AuthController::class, "index"])->name("login");
    Route::post("/login", [AuthController::class, "login"])->name("post.login");
});

Route::middleware("auth")->group(function() {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::get("/user", [UserController::class, "index"])->name("user.index");
    Route::put("/user", [UserController::class, "update"])->name("user.update");
    
    Route::resource("items", ItemController::class);
    
    Route::resource("categories", CategoryController::class);

    Route::resource("sales", SaleController::class);

    Route::get("/cashier", [CashierController::class, "index"])->name("cashier.index");
    Route::post("/cashier", [CashierController::class, "store"])->name("cashier.store");

    Route::delete("/logout", [AuthController::class, "logout"])->name("logout");
});