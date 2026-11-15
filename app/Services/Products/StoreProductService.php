<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Http\Requests\Product\StoreRequest;

class StoreProductService
{
    /**
     * バリデーション済みの配列を受け取って商品を新規登録する
     */
    public function __invoke(array $data): Product {
        // データの作成とDBへの保存を同時に行い、インスタンスを返す
        return Product::create($data);
    }
}