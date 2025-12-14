<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug', // URLなどで使う英数字の名前
    ];

    /**
     * リレーション設定: 商品
     * カテゴリ(ProductCategory)は、たくさんの商品(Product)を持つ
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
