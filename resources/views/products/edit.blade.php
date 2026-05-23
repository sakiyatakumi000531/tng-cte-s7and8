@extends('layouts.s7and8app')

@section('title', '商品情報編集画面')

@section('js')
    @vite(['resources/js/edit-confirm.js'])
@endsection

@section('content')
<form action="{{ route('products.update', $product->id) }}" id = "edit-form" method="POST" enctype="multipart/form-data">
    @method('PUT')

    {{-- 隠しフィールドで、バケツリレーしてきたURLを送信 --}}
    @foreach($query_params as $key => $value)
        <input type = "hidden" name = "back_params[{{ $key }}]" value = "{{ $value }}">
    @endforeach

    @include('products.fields')

    <!-- 更新ボタン -->
    <button type = "submit" class = "btn btn-orange">更新</button>

    <!-- 戻るボタン -->
    <!-- URLのクエリパラメータを引き継いで検索条件を維持 -->
    <a href="{{ route('products.show', array_merge(['id' => $product->id], request()->query())) }}" class = "btn btn-blue">戻る</a>
</form>
@endsection