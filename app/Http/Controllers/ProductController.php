<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. クエリの準備（カテゴリも一緒に取得）
        $query = Product::with('category');

        // 2. 検索条件：カテゴリが選択されていたら絞り込む
        // URLが ?categories[]=1&categories[]=2 となる想定
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        // 3. ページネーション（1ページ12件など）
        $products = $query->orderBy('id', 'desc')->paginate(12);

        // 4. サイドバー用の全カテゴリ
        $categories = ProductCategory::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        // 1. 商品詳細を取得
        $product = Product::with('category')->findOrFail($id);

        // 2. おすすめ（同じカテゴリの商品をランダムに4件表示、自分は除く）
        $recommendations = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'recommendations'));
    }
}
