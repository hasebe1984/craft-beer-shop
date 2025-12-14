<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ▼▼▼ 修正箇所：トップページはこれ1つにする ▼▼▼
// 名前（home）を付けつつ、表示するビューは実際のトップページ（index）を指定
Route::get('/', function () {
    return view('index');
})->name('home');


// ダッシュボード（ログインした人だけが見れるページ）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール編集機能
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ★以前あった2つ目の Route::get('/', ...) は削除しました★

// 商品ページ
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ニュースページ
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');


// お問い合わせ関連のルートグループ
Route::controller(ContactController::class)->group(function () {
    // 入力画面
    Route::get('/contact', 'index')->name('contact.index');
    // 送信処理（POST）
    Route::post('/contact', 'send')->name('contact.submit');
    // 完了画面
    Route::get('/contact/complete', 'complete')->name('contact.complete');
});


// 固定ページ（プライバシーポリシー・特商法）
// 注意: resources/views/static/privacy.blade.php 等が必要です
Route::get('/privacy', function () {
    return view('static.privacy');
})->name('privacy');

Route::get('/tokushoho', function () {
    return view('static.tokushoho');
})->name('tokushoho');

// カート関連
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// 認証ルートの読み込み（絶対に消さない！）
require __DIR__ . '/auth.php';
