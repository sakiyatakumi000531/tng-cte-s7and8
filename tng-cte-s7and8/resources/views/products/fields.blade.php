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

<div class = "form-container"> <!-- FlexBoxで子要素のレイアウトを変更させるためのdiv -->

    <!-- 商品名 -->
    <label for = "product_name">商品名</label>
    <input type = "text" name = "product_name" id = "product_name" value = "{{ old('product_name', $product->product_name ?? '') }}">

    @error('product_name')
    <div class = "error">
        {{ $message }}
    </div>
    @enderror


    <!-- メーカー名 -->
    <label for = "company_id">メーカー名</label>
    <select name = "company_id" id = "company_id">
            <option value = "">選択してください</option>
        @foreach($companies as $company)
            <!-- value属性以後はselectedを判定するための条件判定 -->
            <option value = "{{ $company->id }}" {{ old('company_id', $product->company_id ?? '') == $company->id ? 'selected' : ''}}>
                {{ $company->company_name }}
            </option>
        @endforeach
    </select>

    @error('company_id')
    <div class = "error">
        {{ $message }}
    </div>
    @enderror


    <!-- 価格 -->
    <label for = "price">価格</label>
    <input type = "number" name = "price" id = "price" value = "{{ old('price', $product->price ?? '') }}">

    @error('price')
    <div class = "error">
        {{ $message }}
    </div>
    @enderror


    <!-- 在庫数 -->
    <label for = "stock">在庫数</label>
    <input type = "number" name = "stock" id = "stock" value = "{{ old('stock', $product->stock ?? '') }}">

    @error('stock')
    <div class = "error">
        {{ $message }}
    </div>
    @enderror


    <!-- コメント -->
    <label for = "comment">コメント</label>
    <textarea name = "comment" id = "comment">{{ old('comment', $product->comment ?? '') }}</textarea>

    @error('comment')
        <div class = "error">
            {{ $message }}
        </div>
    @enderror