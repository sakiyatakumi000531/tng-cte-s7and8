<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Companyモデル
 *
 * Company : Product = 1 : 多
 */
class Company extends Model
{
    // トレイト
    use HasFactory;

    /**
     * hasMany結合
     *
     * Company : Product = 1 : 多
     */
    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
