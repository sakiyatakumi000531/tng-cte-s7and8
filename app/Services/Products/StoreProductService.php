<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Http\Requests\Product\StoreRequest;

class CreateProductService
{
    public function __invoke(StoreRequest $request): Product {
        $product = new Product();
        $form = $request->all();

        // _tokenなど、fillableに含まれない余計なパラメータを除外
        unset($form['_token']);

        // fill()で属性($fillableに含まれているもののみ)を一括変更(この時点ではまだDBに保存されない)
        $product->fill($form);

        // SQL(CREATE)を走らせる
        $product->save();

        return $product;
    }
}