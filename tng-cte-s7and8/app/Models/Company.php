<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Companyモデル
 *
 * Company : Product = 1 : 多
 */
class Company extends Model
{
    /**
     * hasMany結合
     *
     * Company : Product = 1 : 多
     */
    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
