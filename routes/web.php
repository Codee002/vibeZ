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
//---------------------------------------------------------------------

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
//---------------------------------------------------------------------

// ----------------------- Route Home -----------------------
Route::get('/home', function () {
    return view('home.components.home');
})->name("home");

Route::get('/', function () {
    return view('home.layouts.layout');
});


//---------------------------------------------------------------------
