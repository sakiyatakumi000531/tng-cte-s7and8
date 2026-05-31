<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

// 単一責任のServiceクラス群
use App\Services\Products\GetProductListWithCompaniesService;
use App\Services\Products\StoreProductService;
use App\Services\Products\UpdateProductService;
use App\Services\Products\DeleteProductService;

class ProductController extends Controller
{
    /**
     * 商品一覧・検索
     */
    public function index(Request $request, GetProductListWithCompaniesService $service) {
        // $request をそのまま丸ごと渡す
        // $resultは配列
        $result = $service($request);

        return view('products.index', [
            'products'  => $result['products'],
            'companies' => $result['companies'],
        ]);
    }

    /**
     * 商品新規登録(入力)
     */
    public function create() {
        // 新規登録なので、すべてのメーカーを取得
        $companies = Company::all();

        return view('products.create', compact('companies'));
        // 上記と下記は同義
        // return view('products.create', ['companies' => $companies]);
    }

    /**
     * 商品新規登録(処理)
     */
    public function store(StoreRequest $request, StoreProductService $service) {
        // FormRequestオブジェクトをそのまま渡す
        $service($request);

        return redirect()->route('products.index');
    }

    /**
     * 商品情報詳細
     */
    public function show($id) {
        // web.phpで 「/products/{id}」 のように定義した場合、{id} の部分は自動的にコントローラメソッドの引数に割り当てられる

        // 指定されたIDで商品を検索。なれけば404ページを表示
        // Productモデルにcompany()というリレーションを用意し、with('company')を付けることで、companyの情報も1回のクエリで取得できる(Eger Loading)
        $product = Product::with('company')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * 商品情報編集(入力)
     */
    public function edit(Request $request, $id) {
        // 指定されたIDで商品を検索。なれけば404ページを表示
        $product = Product::findOrFail($id);

        // セレクトボックス用に全メーカーを取得
        $companies = Company::all();

        return view('products.edit', [
            'product'       => $product,
            'companies'     => $companies,
            // 次(update())にPOST送信が控えているため、viewの引数でクエリパラメータの配列を変数に入れて渡し、editページのhiddenフィールドに埋め込む必要がある
            'query_params'  => $request->query(), // 検索条件の引き継ぎ用
        ]);
    }

    /**
     * 商品情報編集(処理)
     */
    public function update(UpdateRequest $request, $id, UpdateProductService $service) {
        // $id と $request をそのまま Service に渡す
        $service($id, $request);

        // 検索条件を引き継いでリダイレクト
        // 検索条件の取得には$request->all()または$request->input()を使う。なければ空配列
        $params = $request->input('back_params', []);
        return redirect()->route('products.index', $params);
    }

    /**
     * 商品削除
     */
    public function destroy(Request $request, $id, DeleteProductService $service) {
        // $id と $request をそのまま Service に渡す
        $service($id, $request);

        // 前の検索条件を維持したindexページにリダイレクト
        return redirect()->route('products.index', $request->query());
    }
}