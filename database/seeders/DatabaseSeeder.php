<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// 自分でインポート
use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // デフォルトユーザ
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 自作ユーザ
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => 'user1234',
        ]);

        // 基準となる親を先に作る
        $companies = Company::factory(20)->create();

        /*
        子を作る際、先ほど作成した $companies を再利用する
        これにより、ProductFactory内の Company::factory() は無視され、
        $companies の中からランダムにIDが割り振られる
        */
        $products = Product::factory(100)->recycle($companies)->create();

        /*
        子を作る際、先ほど作成した $products を再利用する
        これにより、SaleFactory内の Product::factory() は無視され、
        $products の中からランダムにIDが割り振られる
        */
        Sale::factory(300)->recycle($products)->create();
    }
}
