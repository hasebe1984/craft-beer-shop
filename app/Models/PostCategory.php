<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    // テーブル名が単数形(post_category)なので、明示的に指定します
    protected $table = 'post_category';
}
