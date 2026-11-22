<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Http\Requests\Product\UpdateRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProductService
{
    /**
     * バリデーション済みの配列を受け取って商品を更新する
     */
    public function __invoke(int $id, array $data): Product {
        // 1. idが一致する商品を取得。存在しなければ404エラーを投げる
        $product = Product::findOrFail($id);

        // 2. リクエストに<input name = "img">が含まれているかチェック
        if (isset($data['img']) && $data['img'] instanceof UploadedFile) {

            // A. 既に古い画像が登録されている場合はストレージから削除する
            // 条件分岐 (データベースにパスが登録されている && publicディスク === ./storage/app/public/ 内に実際のファイルが存在するとき)
            if ($product->img_path && Storage::disk('public')->exists($product->img_path)) {

                // publicディスク/products/古い画像ファイル を削除
                Storage::disk('public')->delete($product->img_path);
            }

            // B. 新しい画像を publicディスク/products/ に保存し、パスを取得
            $path = $data['img']->store('products', 'public');

            // C. データベースのカラム名に合わせてパスを格納
            $data['img_path'] = $path;

            // D. アップロードされたファイルオブジェクト自体はデータベースのカラムに合わないため削除
            unset($data['img']);
        }

        // 3. バリデーション済みのデータで更新
        $product->update($data);

        return $product;
    }
}