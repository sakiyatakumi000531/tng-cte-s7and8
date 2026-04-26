<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Saleモデル
 *
 * Sale : Product = 多 : 1
 */
class Sale extends Model
{
    /**
     * belongsTo結合
     *
     * Sale : Product = 多 : 1
     */
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
