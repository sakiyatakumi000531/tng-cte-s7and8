@extends('layouts.s7and8app')

@section('title', '商品新規登録画面')

@section('content')
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('products.fields')
    <label>商品画像<input type="file" name="img_path" accept="image/*"></label>

    <!-- 新規登録ボタン -->
    <button type="submit">新規登録</button>

    <!-- 戻るボタン -->
    <!-- URLのクエリパラメータを引き継いで検索条件を維持 -->
    <a href="{{ route('products.index', request()->query()) }}">戻る</a>
</form>
@endsection