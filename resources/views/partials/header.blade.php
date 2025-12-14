<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'タキシード猫') | IPA専門セレクトショップ</title>    <meta name="description" content="タキシード猫はIPA専門のセレクトショップです。" />
    <meta name="format-detection" content="telephone=no" />

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet" />

 {{-- ▼▼▼ cssフォルダ内の全ファイル（サブフォルダ含む）を自動読み込み ▼▼▼ --}}
 @php
 // Laravelの機能を使って、サブフォルダの中まで全ファイルを検索
 $files = \Illuminate\Support\Facades\File::allFiles(public_path('css'));

 // CSSファイルだけをリストアップするための配列
 $cssFiles = [];

 foreach ($files as $file) {
     // 拡張子が 'css' のファイルだけを対象にする
     if ($file->getExtension() === 'css') {
         // ファイルのパス（例: 00-base/reset.css）を取得して保存
         $cssFiles[] = $file->getRelativePathname();
     }
 }

 // ファイル名・フォルダ名順に並び替え（00-base, 01-component...の順に読み込むため）
 sort($cssFiles);
@endphp

@foreach ($cssFiles as $cssFile)
 <link rel="stylesheet" href="{{ asset('css/' . $cssFile) }}">
@endforeach
{{-- ▲▲▲ 自動読み込みここまで ▲▲▲ --}}

</head>

<body id="top">
    <header class="header">
        <div class="header-banner">
            <p class="header-banner-text">6,000円以上のご注文で送料無料</p>
        </div>
        <div class="header-outer">
            <div class="header-humburger">
                <div class="hamburger-menu" id="hamburger">
                    <span class="bar bar-1"></span>
                    <span class="bar bar-2"></span>
                    <span class="bar bar-3"></span>
                </div>
                <nav class="header-humburger-nav overlay-menu" id="menuOverlay">
                    <ul class="c-button-rotate">
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/') }}#concept" class="c-button-rotate-inner c-button-rotate-inner_large">
                                <div class="c-button-rotate-text c-button-rotate-text_top c-button-rotate-text_large">
                                    concept
                                </div>
                                <div
                                    class="c-button-rotate-text c-button-rotate-text_bottom c-button-rotate-text_large">
                                    concept
                                </div>
                            </a>
                        </li>
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/products') }}" class="c-button-rotate-inner c-button-rotate-inner_large">
                                <div class="c-button-rotate-text c-button-rotate-text_top c-button-rotate-text_large">
                                    products
                                </div>
                                <div
                                    class="c-button-rotate-text c-button-rotate-text_bottom c-button-rotate-text_large">
                                    products
                                </div>
                            </a>
                        </li>
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/news') }}" class="c-button-rotate-inner c-button-rotate-inner_large">
                                <div class="c-button-rotate-text c-button-rotate-text_top c-button-rotate-text_large">
                                    news
                                </div>
                                <div
                                    class="c-button-rotate-text c-button-rotate-text_bottom c-button-rotate-text_large">
                                    news
                                </div>
                            </a>
                        </li>
                    </ul>
                    <ul class="c-button-rotate">
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/contact') }}" class="c-button-rotate-inner">
                                <div class="c-button-rotate-text c-button-rotate-text_top">お問い合わせ</div>
                                <div class="c-button-rotate-text c-button-rotate-text_bottom">お問い合わせ</div>
                            </a>
                        </li>
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/privacy') }}" class="c-button-rotate-inner">
                                <div class="c-button-rotate-text c-button-rotate-text_top">プライバシーポリシー</div>
                                <div class="c-button-rotate-text c-button-rotate-text_bottom">プライバシーポリシー</div>
                            </a>
                        </li>
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/tokushoho') }}" class="c-button-rotate-inner">
                                <div class="c-button-rotate-text c-button-rotate-text_top">特商法に基づく表記</div>
                                <div class="c-button-rotate-text c-button-rotate-text_bottom">特商法に基づく表記</div>
                            </a>
                        </li>
                    </ul>
                </nav>

                <nav class="header-nav">
                    <ul class="c-button-rotate">
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/') }}#concept" class="c-button-rotate-inner">
                                <div class="c-button-rotate-text c-button-rotate-text_top">concept</div>
                                <div class="c-button-rotate-text c-button-rotate-text_bottom">concept</div>
                            </a>
                        </li>
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/products') }}" class="c-button-rotate-inner">
                                <div class="c-button-rotate-text c-button-rotate-text_top">products</div>
                                <div class="c-button-rotate-text c-button-rotate-text_bottom">products</div>
                            </a>
                        </li>
                        <li class="c-button-rotate-outer">
                            <a href="{{ url('/news') }}" class="c-button-rotate-inner">
                                <div class="c-button-rotate-text c-button-rotate-text_top">news</div>
                                <div class="c-button-rotate-text c-button-rotate-text_bottom">news</div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <a class="header-logo" href="{{ url('/') }}#top">
                <img src="{{ asset('img/logo/logo1.png') }}" alt="タキシード猫" width="1024" height="498" />
            </a>
            <ul class="header-list">
                <li>
                    <a href="{{ url('/login') }}" class="c-button-rotate-outer">
                        <div class="c-button-rotate-inner c-button-rotate-inner_orange">
                            <div class="c-button-rotate-text c-button-rotate-text_top">ログイン</div>
                            <div class="c-button-rotate-text c-button-rotate-text_bottom">ログイン</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/cart') }}" class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <circle cx="88" cy="216" r="16" />
                            <circle cx="192" cy="216" r="16" />
                            <path
                                d="M16,32H40L76.75,164.28A16,16,0,0,0,92.16,176H191a16,16,0,0,0,15.42-11.72L232,72H51.11"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                        <span>{{ array_sum(array_column(session('cart', []), 'quantity')) }}</span>                    
                    </a>
                </li>
            </ul>
        </div>
    </header>