<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class GetProductListWithCompaniesService
{
    /**
     * 検索条件に応じた商品一覧と、有効なメーカーリストを取得
     *
     * A. 商品の検索結果一覧用のレコードを取得する処理
     * B. セレクトボックス用のメーカーリストを取得する処理
     */
    public function __invoke(Request $request): array {
        // A-1. 商品検索用のクエリビルダを開始
        $productsQuery = Product::query();

        // A-2. 商品名での部分一致検索
        if ($request->filled('keyword')) {
            $productsQuery->where('product_name', 'LIKE', '%' . $request->keyword . '%');
        }

        // A-3. 企業名での絞り込み
        if ($request->filled('company_id')) {
        $productsQuery->where('company_id', $request->company_id);
        }

        // B-1. セレクトボックス用のクエリビルダを開始
        $companiesQuery = Company::query();

        // B-2. Aの検索条件にヒットした商品の製造メーカーリストを取得
        //      clone()で「検索条件を保持したままのクエリのコピー」を作成
        //      pluck()で特定のカラム(company_id)の値だけを抜き出して新しいコレクションとして取得し、unique()で重複を排除
        $validCompanyIds = $productsQuery->clone()->pluck('company_id')->unique();

        // B-3. B-2で抽出したcompany_id を検索条件にレコードを取得
        $companies = $companiesQuery->whereIn('id', $validCompanyIds)->get();

        // A-4. ページネーションを設定して検索
        //      clone()させる必要があったためBより後に実行
        //      appends($request->all()) または withQueryString() でURLの検索パラメータを維持したままページめくりができるようにする
        $products = $productsQuery->paginate(10)->withQueryString();

        // AとBの検索結果を変数に格納しreturn
        return [
            'products'  => $products,
            'companies' => $companies,
        ];
    }
}