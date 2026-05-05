<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Productモデル
 *
 * Product : Sale = 1 : 多,
 * Product : Company = 多 : 1
 */
class Product extends Model
{
    protected $fillable = [
        'product_name',
        'company_id', // ここを追加するためにオーバーライト
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    // トレイト
    use HasFactory;

    /**
     * hasMany結合
     *
     * Product : Sale = 1 : 多
     */
    public function sales() {
        return $this->hasMany('App\Models\Sale');
    }

    /**
     * belongsTo結合
     *
     * Product : Company = 多 : 1
     */
    public function company() {
        return $this->belongsTo('App\Models\Company');
    }
}
