@extends('layouts.s7and8app')

@section('title', '商品一覧画面')

@section('search_box')
    <form action = "{{ route('product.index') }}" method = "GET">
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
                <td colspan = "2"><a href = "{{ route('product.create') }}">新規登録</a></td>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}.</td> <!-- ID -->
                    <td>商品画像</td> <!-- 商品画像 -->
                    <td>{{ $item->product_name }}</td> <!-- 商品名 -->
                    <td>￥{{ $item->price }}</td> <!-- 価格 -->
                    <td>{{ $item->stock }}</td> <!-- 在庫数 -->
                    <td>{{ $item->company->company_name }}</td> <!-- メーカー名 -->
                    <td><a href = "{{ route('product.show', ['id' => $item->id]) }}">詳細</></td> <!-- 詳細ボタン -->
                    <td>
                        <form action = "{{ route('product.destroy', ['id' => $item->id]) }}" method = "POST">
                            @method('DELETE')
                            @csrf
                            <button type = "submit">削除</button> <!-- TODO: class属性を付与し、確認ダイアログを表示させる -->
                        </form>
                    </td> <!-- 削除ボタン -->
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
@endsection