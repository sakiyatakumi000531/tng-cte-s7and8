<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Saleモデル
 *
 * Sale : Product = 多 : 1
 */
class Sale extends Model
{
    // トレイト
    use HasFactory;

    /**
     * belongsTo結合
     *
     * Sale : Product = 多 : 1
     */
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
