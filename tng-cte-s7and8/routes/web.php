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
Route::get('/product', [ProductController::class, 'index'])->name('product.index');

// 商品新規登録(入力)
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');

// 商品新規登録(処理)
Route::post('/product', [ProductController::class, 'store'])->name('product.store');

// 商品情報詳細
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// 商品情報編集(入力)
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');

// 商品情報編集(処理)
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');

// 削除
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');