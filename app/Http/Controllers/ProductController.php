<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 自分で追記
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

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


    public function create(Request $request) {
        $companies = Company::all();
        return view('products.create', compact('companies'));
        // 上記と下記は同義
        // return view('products.create', ['companies' => $companies]);
    }


    public function store(StoreRequest $request) {
        $product = new Product();
        $form = $request->all();
        unset($form['_token']);
        $product->fill($form)->save();
        return redirect()->route('products.index');
    }


    public function show($id) {
        // web.phpで 「/products/{id}」 のように定義した場合、{id} の部分は自動的にコントローラメソッドの引数に割り当てられる
        // 指定されたIDで商品を検索。なれけば404ページを表示
        // Productモデルにcompany()というリレーションを用意し、with('company')を付けることで、companyの情報も1回のクエリで取得できる(Eger Loading)
        $product = Product::with('company')->findOrFail($id);

        return view('products.show', compact('product'));
    }


    public function edit(Request $request, $id) {

        $product = Product::findOrFail($id);

        // セレクトボックス用に全メーカーを取得
        $companies = Company::all();

        return view('products.edit', [
            'product'       => $product,
            'companies'     => $companies,
            // 次(update())にPOST送信が控えているため、viewの引数でクエリパラメータの配列を変数に入れて渡し、editページのhiddenフィールドに埋め込む必要がある
            'query_params'  => $request->query(),
        ]);
    }


    public function update(UpdateRequest $request, $id) {
        $product = Product::findOrFail($id);

        // バリデーション済みの「DB保存用データ」のみで更新
        $product->update($request->validated());

        // 検索条件などは $request->all()や$request->input()から取得する。なければ空配列
        $params = $request->input('back_params', []);

        return redirect()->route('products.index', $params);
    }


    public function destroy(Request $request, $id) {
        Product::findOrFail($id)->delete();

        // 前の検索条件を維持したindexページにリダイレクト
        return redirect()->route('products.index', $request->query());
    }
}