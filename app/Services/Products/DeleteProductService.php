<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Http\Request;

class DeleteProductService
{
    public function __invoke(int $id, Request $request): void {
        // idが一致する商品を削除。存在しなければ404エラーを投げる
        Product::findOrFail($id)->delete();
    }
}