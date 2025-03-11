<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\member\ContactController;
use App\Http\Controllers\Member\SettingController;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isMember;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.components.home');
});

// ----------------------- Route Admin -----------------------
Route::prefix("/admin")
    ->name("admin.")
    ->middleware(['auth', isAdmin::class])
    ->group(function () {
        // Trang index
        Route::get('/', function () {
            return view('admin.index');
        });

        // Trang Category
        Route::resource('category', CategoryController::class);

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
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenController::class, "showFormLogin"])->name("login");
    Route::post('/login', [AuthenController::class, "handleLogin"]);
    Route::get('/checkLoginToken/{userId}/{token}', [AuthenController::class, "checkLoginToken"])->name("checkLoginToken");
    Route::get('/register', [AuthenController::class, "showFormRegister"])->name("register");
    Route::post('/register', [AuthenController::class, "handleRegister"])->name("register");
    Route::get('/forgot', [AuthenController::class, "showFormForgot"])->name("forgot");
    Route::post('/handleForgot', [AuthenController::class, "handleForgot"])->name("handleForgot");
    Route::get('/sendBy', [AuthenController::class, "sendBy"])->name("sendBy");
    Route::post('/getTokenForgot/{user}', [AuthenController::class, "getTokenForgot"])->name("getTokenForgot");
    Route::get('/checkForgotToken/{userId}/{token}', [AuthenController::class, "checkForgotToken"])->name("checkForgotToken");
    Route::get('/reset', [AuthenController::class, "showFormReset"])->name("reset");
    Route::post('/handleReset', [AuthenController::class, "handleReset"])->name("handleReset");
});
Route::middleware(['auth'])->group(function() {
    Route::get('/activeEmail/{token}', [AuthenController::class, "activeEmail"])->name("activeEmail");
    Route::get('/sendEmail', [AuthenController::class, "sendEmail"])->name("sendEmail");
    Route::post('/sendEmail', [AuthenController::class, "sendEmail"])->name("sendEmail");
    Route::get('/logout', [AuthenController::class, "logout"])->name("logout");
});

// ----------------------- Route Home -----------------------
Route::get('/home', [HomeController::class, "index"])->name("home");

Route::get('/', function () {
    return view('pages.layouts.layout');
});

// ----------------------- Route Product -----------------------
Route::get('/product', [ProductController::class, "showListProduct"])->name("product");

Route::get('/detail', function () {
    return view('pages.components.detail');
})->name("detail");

// ----------------------- Route Cart -----------------------
Route::get('/cart', function () {
    return view('pages.components.cart');
})->name("cart");

// ----------------------- Route Contact -----------------------
Route::middleware(['auth', isMember::class])->group(function() {
    Route::get('/contact', [ContactController::class, "index"])->name("contact");
    Route::post('/handleContact', [ContactController::class, "handleContact"])->name("handleContact");

});

// ----------------------- Route Order -----------------------
Route::get('/order_detail', function () {
    return view('pages.components.order_detail');
})->name("order_detail");
Route::get('/order_history', function () {
    return view('pages.components.order_history');
})->name("order_history");

// ----------------------- Route Setting -----------------------

Route::controller(SettingController::class)
    ->prefix('/setting')
    ->name('setting.')
    ->middleware(['auth', isMember::class])
    ->group(function () {
        Route::get('info', 'showUserInformation')->name("info");
        Route::put('updateEmailPhone', "updateEmailPhone")->name("updateEmailPhone");
        Route::put('updateName', "updateName")->name("updateName");
        Route::put('updateBirthday', "updateBirthday")->name("updateBirthday");
        Route::put('updateGender', "updateGender")->name("updateGender");

        Route::get('security', 'showSecurity')->name("security");
        Route::put('changePassword', "changePassword")->name("changePassword");
        Route::post('authTwoStep', "authTwoStep")->name("authTwoStep");
    });
