<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Admin\GeneralImageController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RankController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\CartController;
use App\Http\Controllers\member\ContactController;
use App\Http\Controllers\Member\DeliveryInfoController;
use App\Http\Controllers\Member\EvaluateController;
use App\Http\Controllers\Member\OrderController;
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

        // Trang Payment Method
        Route::resource("payment_method", PaymentMethodController::class);

        // Trang Payment Method
        Route::resource("distributor", DistributorController::class);

        // Trang Rank
        Route::resource("rank", RankController::class);

        // Trang General
        Route::get("general", [GeneralImageController::class, "index"])->name("general.index");
        Route::post("general/store", [GeneralImageController::class, "store"])->name("general.store");

        // Trang User
        Route::get("account/export", [AccountController::class, "exportAccounts"])->name("account.export");
        Route::resource("account", AccountController::class);

        // Trang Statistical
        Route::get("statistical", [StatisticalController::class, "index"])->name("statistical.index");
        Route::get("statistical/revenue", [StatisticalController::class, "revenue"])->name("statistical.revenue");
        Route::get("statistical/export", [StatisticalController::class, "export"])->name("statistical.export");

        // Trang Discount
        Route::resource("discount", DiscountController::class);
        Route::post("discount/activedDiscount/{discount}", [DiscountController::class, "activedDiscount"])->name("discount.activedDiscount");
        Route::post("discount/disabledDiscount/{discount}", [DiscountController::class, "disabledDiscount"])->name("discount.disabledDiscount");

        // Trang Order
        Route::get("order", [OrderAdminController::class, "index"])->name("order.index");
        Route::get("order/edit/{order}", [OrderAdminController::class, "edit"])->name("order.edit");
        Route::get("order/show/{order}", [OrderAdminController::class, "show"])->name("order.show");
        Route::get("order/accept/{order}", [OrderAdminController::class, "accept"])->name("order.accept");
        Route::post("order/reject/{order}", [OrderAdminController::class, "reject"])->name("order.reject");
        Route::post("order/handle/{order}", [OrderAdminController::class, "handleOrder"])->name("order.handle");
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
    Route::post('/handleReset/{user}', [AuthenController::class, "handleReset"])->name("handleReset");
});
Route::middleware(['auth'])->group(function () {
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
Route::get('/product/detail/{product}', [ProductController::class, "productDetail"])->name("product.detail");

// ----------------------- Route Cart -----------------------
Route::middleware(['auth', isMember::class])->group(function () {
    Route::post('/addToCart', [CartController::class, "addToCart"])->name("addToCart");
    Route::get('/cart', [CartController::class, "showCart"])->name("cart");
    Route::put('/updateQuantity', [CartController::class, "updateQuantity"])->name("updateQuantity");
    Route::get('/deleteCart/{cart_detail}', [CartController::class, "deleteCart"])->name("deleteCart");
});

// ----------------------- Route Order -----------------------
Route::middleware(['auth', isMember::class])->group(function () {
    Route::post("/order", [OrderController::class, "order"])->name("order");
    Route::post("/order/store", [OrderController::class, "store"])->name("order.store");
    Route::get("order/history", [OrderController::class, "history"])->name("order.history");
    Route::get("order/history/{order}", [OrderController::class, "detail"])->name("order.history.detail");
    Route::post("order/abort/{order}", [OrderController::class, "abort"])->name("order.abort");
    Route::post("order/receive/{order}", [OrderController::class, "receive"])->name("order.receive");
    Route::get("order/detail", [OrderController::class, "detail"])->name("order.detail");
});
Route::get("order/pdf/{order}", [OrderController::class, "printInvoice"])->name("order.pdf");

// ----------------------- Route DeliveryInfo -----------------------
Route::middleware(['auth', isMember::class])->group(function () {
    Route::resource("delivery", DeliveryInfoController::class);
});

// ----------------------- Route Evaluate -----------------------
Route::middleware(['auth', isMember::class])->group(function () {
    Route::get("evaluate/create/{order}", [EvaluateController::class, "create"])->name('evaluate.create');
    Route::get("evaluate/show/{order}", [EvaluateController::class, "show"])->name('evaluate.show');
    Route::post("evaluate/store/{order}", [EvaluateController::class, "store"])->name('evaluate.store');
    Route::get("evaluate/edit/{order}/{evaluate}", [EvaluateController::class, "edit"])->name('evaluate.edit');
    Route::post("evaluate/update/{order}/{evaluate}", [EvaluateController::class, "update"])->name('evaluate.update');
});
Route::get("evaluate/{productId}", [EvaluateController::class, "index"])->name('evaluate.index');

// ----------------------- Route Contact -----------------------
Route::middleware(['auth', isMember::class])->group(function () {
    Route::get('/contact', [ContactController::class, "index"])->name("contact");
    Route::post('/handleContact', [ContactController::class, "handleContact"])->name("handleContact");

});

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
