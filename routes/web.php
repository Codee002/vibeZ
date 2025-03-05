<?php

use App\Http\Controllers\AuthenController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.components.home');
});

// ----------------------- Route Admin -----------------------
Route::prefix("/admin")
    ->name("admin.")
    ->group(function () {
        // Trang index
        Route::get('/', function () {
            return view('admin.index');
        });

        // Category
        Route::controller(CategoryController::class)
            ->prefix("/category")
            ->name("category.")
            ->group(function () {
                Route::get("/", "index")->name("index");
                Route::get("/create", "create")->name("create");
                Route::post("/store", "store")->name("store");
                Route::get("/edit/{category}", "edit")->name("edit");
                Route::put("/update/{category}", "update")->name("update");
                Route::get("/detail/{category}", "detail")->name("detail");
                Route::get("/search", "search")->name("search");
                Route::delete("/destroy/{category}", "destroy")->name("destroy");
            });

        // Trang Warehouse
        Route::resource('warehouse', WarehouseController::class);
        Route::post('warehouse/activedProduct/{warehouse_detail}', [WarehouseController::class, "activedProduct"])->name('warehouse.activedProduct');
        Route::post('warehouse/disabledProduct/{warehouse_detail}', [WarehouseController::class, "disabledProduct"])->name('warehouse.disabledProduct');
        Route::delete('warehouse/destroyWarehouseDetail/{warehouse_detail}', [WarehouseController::class, "destroyWarehouseDetail"])->name('warehouse.destroyWarehouseDetail');

        // Trang Product
        Route::resource('product', ProductController::class);

        // Trang Receipt
        Route::get("receipt/choiceProduct", [ReceiptController::class, 'choiceProduct'])->name('receipt.choiceProduct');
        Route::post("receipt/handleReceipt/{receipt}", [ReceiptController::class, "handleReceipt"])->name('receipt.handleReceipt');
        Route::resource("receipt", ReceiptController::class);

    });
// ----------------------- Route Auth -----------------------
Route::get('/login', [AuthenController::class, "showFormLogin"])->name("login");
Route::post('/login', [AuthenController::class, "handleLogin"]);

Route::get('/register', [AuthenController::class, "showFormRegister"])->name("register");
Route::post('/register', [AuthenController::class, "handleRegister"])->name("register");

Route::get('/forgot', [AuthenController::class, "showFormForgot"])->name("forgot");
// Route::post('/forgot', [AuthenController::class, "handleForgot"])->name("forgot");

Route::get('/logout', [AuthenController::class, "logout"])->name("logout");


// ----------------------- Route Home -----------------------
Route::get('/home', function () {
    return view('pages.components.home');
})->name("home");

Route::get('/', function () {
    return view('pages.layouts.layout');
});

// ----------------------- Route Product -----------------------
Route::get('/product', function () {
    return view('pages.components.product');
})->name("product");

Route::get('/detail', function () {
    return view('pages.components.detail');
})->name("detail");

// ----------------------- Route Cart -----------------------
Route::get('/cart', function () {
    return view('pages.components.cart');
})->name("cart");

// ----------------------- Route Contact -----------------------
Route::get('/contact', function () {
    return view('pages.components.contact');
})->name("contact");

// ----------------------- Route Order -----------------------
Route::get('/order_detail', function () {
    return view('pages.components.order_detail');
})->name("order_detail");
Route::get('/order_history', function () {
    return view('pages.components.order_history');
})->name("order_history");

// ----------------------- Route Setting -----------------------
Route::get('/setting', function () {
    return view('pages.components.setting');
})->name("setting");

Route::get('/security', function () {
    return view('pages.components.security');
})->name("security");
