<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 外部キー
            'company_id' => Company::factory(),
            // 商品名(varchar)
            'product_name' => $this->faker->unique()->word(),
            // 価格(int)
            'price' => $this->faker->numberBetween(100, 300),
            // 在庫数(int)
            'stock' => $this->faker->numberBetween(0, 999),
            // コメント(text / Nullable)
            'comment' => $this->faker->optional()->realText(100),
            // 商品画像(varchar / Nullable)
            'img_path' => $this->faker->boolean(70) ? $this->copySampleProductImage() : null,
            // 作成日は1年前から現在時刻の間でランダム生成。format()不要と思われるが、念のためformat()しておく
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            // 更新日は現在時刻で固定。format()不要
            'updated_at' => now(),
        ];
    }

    /**
     * リポジトリ内のサンプル画像を public ディスクにコピーし、保存先パスを返す
     */
    private function copySampleProductImage(): ?string
    {
        $sourceDir = database_path('factories/stubs/products');

        if (!File::isDirectory($sourceDir)) {
            return null;
        }

        /*
            1. File::files($sourceDir) が実行される: $sourceDir直下にあるファイルの一覧を取得し、各ファイルを表現する \SplFileInfo オブジェクトの配列を返す
            2. collect(...) が実行される: 1.で得られた配列を collect()に渡し、Laravel の Illuminate\Support\Collection インスタンスに変換
            3. ->filter(...)が実行される
                3-a. $file->isFile() が実行される: 各要素ごとに isFile() が呼ばれ、そのパスが通常のファイルであるかを判定し、true/false が返される
                3-b. 無名関数から return される: isFile() の結果が filter() のコールバックの戻り値として返り、true の要素だけを残した新しいコレクションが絞り込まれる。
            4. 絞り込まれた新しいコレクションが $sampleFiles に格納される
        */
        $sampleFiles = collect(File::files($sourceDir))
            ->filter(function (\SplFileInfo $file):bool {
                return $file->isFile();
            });

        // もし条件を満たす画像ファイルの数が0件だったら、null を返してメソッドを終了
        if ($sampleFiles->isEmpty()) {
            return null;
        }

        // 残っているファイルコレクションから無作為に1つ取り出し、代入
        /** @var \SplFileInfo $selectedFile */
        $selectedFile = $sampleFiles->random();

        // 拡張子を取得し小文字に統一
        $extension = strtolower($selectedFile->getExtension() ?: 'jpg');

        // 重複しにくい一意のIDを生成し、'products/' . <UUID> . '.' . <拡張子> の形式で相対パスを作成
        $storagePath = 'products/' . Str::uuid() . '.' . $extension;

        // 元ファイルのフルパスを取得し、ファイルの中身(バイナリ)をメモリ上に読み込み、$contentsに格納する
        $contents = File::get($selectedFile->getPathname());

        // バイナリを読み込んで $contents を public ディスク(storage/app/public/)の $storagePath へ書き出す(サブディレクトリ(products)がなければ自動で作成)
        Storage::disk('public')->put($storagePath, $contents);

        // DBに保存するための保存先パスを相対パスで返す
        return $storagePath;
    }
}
