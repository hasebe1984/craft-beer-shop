<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // 「記事」は「ひとつのカテゴリー」に属している（多対1）
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }
}
