<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Http\Requests\Product\UpdateRequest;

class UpdateProductService
{
    public function __invoke(int $id, UpdateRequest $request): Product {
        // idが一致する商品を取得。存在しなければ404エラーを投げる
        $product = Product::findOrFail($id);

        // バリデーション済みのデータで更新
        $product->update($request->validated());

        return $product;
    }
}