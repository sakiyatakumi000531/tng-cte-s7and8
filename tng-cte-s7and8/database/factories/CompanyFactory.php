<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 主キーは設定不要
            // メーカー名(string)
            'company_name' => $this->faker->unique()->company(),
            // 住所(string)
            'street_address' => $this->faker->unique()->address(),
            // 代表者名(string)
            'representative_name' => $this->faker->unique()->name(),
            // 作成日は1年前から現在時刻の間でランダム生成。format()不要と思われるが、念のためformat()しておく
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            // 更新日は現在時刻で固定。format()不要
            'updated_at' => now(),
        ];
    }
}
