<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            // 外部キー(bigint unsigned)
            'company_id' => Company::factory(),
            // 商品名(varchar)
            'product_name' => $this->faker->word(),
            // 価格(int)
            'price' => $this->faker->numberBetween(100, 300),
            // 在庫数(int)
            'stock' => $this->faker->numberBetween(0, 999),
            // コメント(text / Nullable)
            'comment' => $this->faker->optional()->realText(100),
            // 商品画像(varchar / Nullable) width: 640, height: 480, 画像のカテゴリー: 'products' の画像URL または Null
            'img_path' => $this->faker->optional()->imageUrl(640, 480, 'products')
        ];
    }
}
