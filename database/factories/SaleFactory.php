<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Product;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
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
            'product_id' => Product::factory(),
            // 作成日は1年前から現在時刻の間でランダム生成。format()不要と思われるが、念のためformat()しておく
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            // 更新日は現在時刻で固定。format()不要
            'updated_at' => now(),
        ];
    }
}
