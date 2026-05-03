<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Company;

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
            // 商品画像(varchar / Nullable) width: 640, height: 480, 画像のカテゴリー: 'products' の画像URL または Null
            'img_path' => $this->faker->unique()->optional()->imageUrl(640, 480, 'products'),
            // 作成日は1年前から現在時刻の間でランダム生成。format()不要と思われるが、念のためformat()しておく
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            // 更新日は現在時刻で固定。format()不要
            'updated_at' => now(),
        ];
    }
}
