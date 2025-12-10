<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// トップページ
Route::get('/', function () {
    return view('index');
});

// 商品ページ
Route::get('/products', function () {
    return view('products.index');
});
Route::get('/products/show', function () {
    return view('products.show');
});

// ニュースページ
Route::get('/news', function () {
    return view('news.index');
});
Route::get('/news/show', function () {
    return view('news.show');
});

// 固定ページ
Route::get('/privacy', function () {
    return view('static.privacy');
});
Route::get('/tokushoho', function () {
    return view('static.tokushoho');
});

// お問い合わせ
Route::get('/contact', function () {
    return view('contact.index');
});
Route::get('/contact/complete', function () {
    return view('contact.complete');
});

// ログイン
Route::get('/login', function () {
    return view('auth.login');
});