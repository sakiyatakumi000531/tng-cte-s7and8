<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/product', [ProductController::class, 'index'])->name('index');
// Route::post('/product', [ProductController::class, 'index']);
Route::get('/product/add', [ProductController::class, 'add'])->name('add');