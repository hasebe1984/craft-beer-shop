<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // カート画面表示
    public function index()
    {
        // セッションからカートデータを取得（なければ空の配列）
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    // カートに追加処理
    public function store(Request $request)
    {
        // 1. バリデーション（不正なデータ弾き）
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // 2. 商品情報をDBから取得
        $product = Product::findOrFail($productId);

        // 3. 現在のカート情報を取得
        $cart = session()->get('cart', []);

        // 4. カートの中身を更新
        if (isset($cart[$productId])) {
            // すでにカートに入っている商品なら、個数を足す
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // 新しい商品なら、データをセットする
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'category_name' => $product->category->name, // カテゴリ名も便利なので入れておく
            ];
        }

        // 5. セッションに保存
        session()->put('cart', $cart);

        // 6. カートページへリダイレクト（完了メッセージ付き）
        // return redirect()->route('cart.index')->with('success', '商品をカートに追加しました！');
        return back()->with('success', '商品をカートに追加しました！');
    }

    public function update(Request $request, $id)
    {
        // 数量が1以上の整数かチェック
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart');

        // カートに商品があれば数量を更新
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', '数量を変更しました');
        }

        return redirect()->back();
    }

    // カートから削除
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', '商品を削除しました。');
    }
}
