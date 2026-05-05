<!--
    old('変数', 変数 ?? '')について

        if (直前の入力がある) {
            第1引数の値を表示
        } else if (第2引数の左辺の値がnullでない) {
            左辺の値を表示
        } else {
            右辺の値(空文字)を表示
        }

    これにより、1つのファイルで「登録(直前の入力なし)」と「編集(controllerから渡される値あり)」の両方に対応できる
-->

<label>商品名<input type = "text" name = "product_name" value = "{{ old('product_name', $product->product_name ?? '') }}"></label>
<label>メーカー<input type = "text" name = "company_name" value = "{{ old('company_name', $product->company->company_name ?? '') }}"></label>
<label>価格<input type = "number" name = "price" value = "{{ old('price', $product->price ?? '') }}"></label>
<label>在庫数<input type = "number" name = "stock" value = "{{ old('stock', $product->stock ?? '') }}"></label>
<label>コメント<textarea name = "comment">{{ old('comment', $product->comment ?? '') }}</textarea></label>