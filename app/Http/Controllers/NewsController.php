<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // クエリの準備
        $query = Post::with('category')->orderBy('published_at', 'desc');

        // ★ここが重要：チェックされたカテゴリーだけを検索条件に追加する
        if ($request->has('categories')) {
            $slugs = $request->input('categories'); // チェックされたslugの配列

            $query->whereHas('category', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        // ページネーション（絞り込み条件を維持する設定つき）
        $posts = $query->paginate(5)->withQueryString();

        $categories = PostCategory::all();

        return view('news.index', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }


    public function show($id)
    {
        // 1. 表示するメインの記事を取得
        $post = Post::with('category')->findOrFail($id);

        // 2. サイドバー用の全カテゴリーリスト
        $categories = PostCategory::all();

        // 3. ★ここが重要：関連記事（同じカテゴリの記事）を取得
        $related_posts = Post::where('category_id', $post->category_id) // 同じカテゴリIDを持つものを探す
            ->where('id', '!=', $id)           // 今見ている記事自体は除外する
            ->limit(2)                         // 2件だけ取得
            ->inRandomOrder()                  // ランダムに選ぶ（または latest() で新しい順）
            ->get();

        return view('news.show', [
            'post' => $post,
            'categories' => $categories,
            'related_posts' => $related_posts
        ]);
    }
}
