@extends('layouts.s7and8app')

@section('title', '商品一覧画面')

@section('search_box')
    <form action = "{{ route('products.index') }}" method = "GET">
        @csrf
        <!-- 商品名の部分一致検索用入力フォーム -->
        <input type = "text" name = "keyword" value = "{{ request('keyword') }}" placeholder = "検索キーワード">

        <!-- メーカー名での絞り込み用セレクトボックス -->
        <select name = "company_id">
            <option value = "">メーカー名</option>
            @foreach($companies as $company)
                <option value = "{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : ''}}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>

        <!-- 検索ボタン -->
        <button type = "submit">検索</button>
        <!-- リセットボタン -->
        <a href = "{{ route('products.index') }}">リセット</a>
    </form>
@endsection

@section('content')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <!-- URLのクエリパラメータを引き継いで検索条件を維持したままcreateページに移動 -->
                <td colspan = "2"><a href = "{{ route('products.create', request()->query()) }}">新規登録</a></td>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}.</td> <!-- ID -->
                    <td>商品画像</td> <!-- 商品画像 -->
                    <td>{{ $product->product_name }}</td> <!-- 商品名 -->
                    <td>￥{{ $product->price }}</td> <!-- 価格 -->
                    <td>{{ $product->stock }}</td> <!-- 在庫数 -->
                    <td>{{ $product->company->company_name }}</td> <!-- メーカー名 -->
                    <td>
                        <!-- 詳細ボタン -->
                        <!-- URLのクエリパラメータを引き継いで検索条件を維持 -->
                        <!-- 結合演算子で配列同士を結合 -->
                        <a href = "{{ route('products.show', ['id' => $product->id] + request()->query()) }}">詳細</a>
                    </td>
                    <td>
                        <!-- 削除ボタン -->
                        <form action = "{{ route('products.destroy', ['id' => $product->id] + request()->query()) }}" method = "POST">
                            @method('DELETE')
                            @csrf
                            <button type = "submit">削除</button> <!-- TODO: class属性を付与し、確認ダイアログを表示させる -->
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
@endsection