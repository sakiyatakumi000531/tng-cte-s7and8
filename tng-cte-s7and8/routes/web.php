<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// --- 商品管理機能 ---

// 商品一覧・検索
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品新規登録(入力)
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 商品新規登録(処理)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 商品情報詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 商品情報編集(入力)
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 商品情報編集(処理)
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// 削除
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');