<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Http\Requests\Product\UpdateRequest;

class UpdateProductService
{
    /**
     * バリデーション済みの配列を受け取って商品を更新する
     */
    public function __invoke(int $id, array $data): Product {
        // idが一致する商品を取得。存在しなければ404エラーを投げる
        $product = Product::findOrFail($id);

        // バリデーション済みのデータで更新
        $product->update($data);

        return $product;
    }
}