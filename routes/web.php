<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ----------------------- Route Admin -----------------------
Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('admin/widgets/small-box', function () {
    return view('admin.components.widgets.small-box'); 
})->name('admin.small-box');

// ----------------------- Route Auth -----------------------
Route::get('/login', function () {
    return view('auth.components.login');
})->name("login");

Route::get('/register', function () {
    return view('auth.components.register');
})->name("register");

Route::get('/forgot', function () {
    return view('auth.components.forgot');
})->name("forgot");

Route::get('/active_email', function () {
    return view('auth.components.activeEmail');
})->name("active_email");


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

