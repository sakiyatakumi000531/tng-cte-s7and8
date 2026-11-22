<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Http\Requests\Product\StoreRequest;
use Illuminate\Http\UploadedFile;

class StoreProductService
{
    /**
     * バリデーション済みの配列を受け取って商品を新規登録する
     */
    public function __invoke(array $data): Product {
        // 1. リクエストに<input name = "img">が含まれているかチェック
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {
            // storage/app/public/products/ に保存し、相対パスを取得する
            // 例: 'products/abc123xyz.jpg'
            $path = $data['img']->store('products', 'public');

            // 2. データベースのカラム名に合わせてパスを格納
            $data['img_path'] = $path;

            // 3. アップロードされたファイルオブジェクト自体はDBのカラムに合わないため削除
            unset($data['img']);
        }

        // 4. パスが含まれた配列でレコードを作成し、インスタンスを返す
        return Product::create($data);
    }
}