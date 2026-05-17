@extends('layouts.s7and8app')

@section('title', '商品情報詳細画面')

@section('content')
    <table class = "table-basic">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $product->id }}.</td>
            </tr>
            <tr>
                <th>商品画像</th>
                <td>画像</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>{{ $product->product_name }}</td>
            </tr>
            <tr>
                <th>メーカー</th>
                <td>{{ $product->company->company_name }}</td>
            </tr>
            <tr>
                <th>価格</th>
                <td>￥{{ $product->price }}</td>
            </tr>
            <tr>
                <th>在庫数</th>
                <td>{{ $product->stock }}</td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>{{ $product->comment }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 編集ボタン -->
    <!-- URLのクエリパラメータを引き継いで検索条件を維持 -->
    <!-- 結合演算子で配列同士を結合 -->
    <a href="{{ route('products.edit', ['id' => $product->id] + request()->query()) }}">編集</a>

    <!-- 戻るボタン -->
    <a href="{{ route('products.index', request()->query()) }}">戻る</a>
@endsection