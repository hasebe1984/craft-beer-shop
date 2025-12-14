<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 変更可能なカラムを指定（Mass Assignment対策）
    protected $fillable = [
        'category_id', // カテゴリとの紐付け用
        'name',
        'price',
        'image_url',
        'description',
        'ibu',      // IBU (苦味の単位)
        'abv',      // ABV (アルコール度数)
        'country',  // 原産国
    ];

    /**
     * リレーション設定: カテゴリ
     * 商品(Product)は、ひとつのカテゴリ(ProductCategory)に属する
     */
    public function category()
    {
        // belongsTo(相手のモデル名)
        return $this->belongsTo(ProductCategory::class);
    }
}
