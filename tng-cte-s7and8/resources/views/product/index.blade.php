@extends('layouts.s7and8app')

@section('title', '商品一覧画面')

@section('search_box')
<p>検索ボックス</p>
@endsection

@section('content')
    <table>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <td><a href = "{{route('add')}}">新規登録</a></td>
        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{$item -> id}}</td> <!-- ID -->
                <td>商品画像</td> <!-- 商品画像 -->
                <td>{{$item -> product_name}}</td> <!-- 商品名 -->
                <td>{{$item -> price}}</td> <!-- 価格 -->
                <td>{{$item -> stock}}</td> <!-- 在庫数 -->
                <td>{{$item -> company_id}}</td> <!-- メーカー名 -->
            </tr>
        @endforeach
    </table>
@endsection

<!-- @section('pager') -->
<!-- @endsection -->
