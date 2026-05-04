<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 自分で追記
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    public function index(Request $request) {

        // --- クエリビルダを開始 ---
        $query = Product::query();

        // A. 商品の検索結果一覧用のレコードを取得する処理
        // B. セレクトボックス用のメーカーリストを取得する処理

            // A-1-1. 商品名での部分一致検索
            if ($request->filled('keyword')) {
                $query->where('product_name', 'LIKE', '%' . $request->keyword . '%');
            }

            // A-2-1. 企業名での絞り込み
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }


            // B-1-1. 2と3の検索条件にヒットした商品の製造メーカーのIDを配列で取得
            //      clone()で「検索条件を保持したままのクエリのコピー」を作成
            //      pluck()で特定のカラム(company_id)の値だけを抜き出して新しいコレクションとして取得し、unique()で重複を排除
            $validCompanyIds = $query->clone()->pluck('company_id')->unique();

            // B-1-2. companyテーブルから B-1で抽出したcompany_id を検索条件にレコードを取得
            $companies = Company::query()->whereIn('id', $validCompanyIds)->get();


            // A-3-1. ページネーションを設定して検索(B用にclone()させる必要があったためBより後に実行)
            //      appends($request->all()) または withQueryString() でURLの検索パラメータを維持したままページめくりができるようにする
            $products = $query->paginate(20)->withQueryString();


        // AとBの検索結果を変数に格納しindexページに渡す
        return view('products.index', [
                'products' => $products,
                'companies' => $companies,
        ]);
    }
}