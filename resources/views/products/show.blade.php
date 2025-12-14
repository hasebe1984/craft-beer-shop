@section('title', $product->name)
@include('partials.header')

{{-- ▼▼▼ 成功メッセージ（successに修正） ▼▼▼ --}}
@if(session('success'))
    <div id="cart-notification" class="cart-notification">
        {{ session('success') }}
    </div>
@endif
{{-- ▲▲▲ 追加ここまで ▲▲▲ --}}

<main>
    <section class="product-single l-section-top">
        <div class="product-single-box">
            <div class="product-single-box-wrap">
                <h2 class="product-single-name">{{ $product->name }}</h2>
                <picture class="product-single-thumbnail">
                    <source srcset="{{ asset($product->image_url . '.webp') }}" type="image/webp" />
                    <img src="{{ asset($product->image_url . '.jpg') }}" alt="{{ $product->name }}" width="1563" height="1024" />
                </picture>
            </div>

            <div class="product-single-img">
                @for($i = 0; $i < 3; $i++)
                <picture>
                    <source srcset="{{ asset($product->image_url . '.webp') }}" type="image/webp" />
                    <img src="{{ asset($product->image_url . '.jpg') }}" alt="パッケージ画像" width="1024" height="1024" />
                </picture>
                @endfor
            </div>
        </div>

        <div class="product-single-box2">
            <div>
                <div class="product-single-spec">
                    <div>{{ $product->category->name }}</div>
                    <div><span>IBU</span>{{ $product->ibu ?? '-' }}</div>
                    <div><span>ABV</span>{{ $product->abv ?? '-' }}%</div>
                    <div>{{ $product->country ?? 'Japan' }}</div>
                </div>

                <div class="product-single-description">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <div>
                <p class="product-single-price">¥{{ number_format($product->price) }}-</p>
                
                {{-- カート追加フォーム --}}
                <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="product-single-stepper">
                        <button type="button" aria-label="数量を減らす" onclick="this.nextElementSibling.stepDown()">-</button>
                        <input type="number" name="quantity" value="1" min="1" max="99" inputmode="numeric" readonly />
                        <button type="button" aria-label="数量を増やす" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>

                    {{-- スクロール位置を記憶して送信 --}}
                    <button type="submit" class="c-button-slide" onclick="saveScrollPosition()">
                        <span class="c-button-slide-text">カートに追加する</span>
                    </button>
                </form>

            </div>
        </div>

        <div class="c-space c-space_primary c-space_img"></div>
        <div class="c-space"></div>

        <div class="product-single-recommend">
            <p class="c-nav-title">あなたへのオススメ</p>
            <div class="product-single-recommend-container">
                @if($recommendations->isEmpty())
                    <p>関連商品はありません。</p>
                @endif
                @foreach($recommendations as $item)
                <a href="{{ route('products.show', $item->id) }}" class="product-single-recommend-item">
                    <picture>
                        <source srcset="{{ asset($item->image_url . '.webp') }}" type="image/webp" />
                        <img src="{{ asset($item->image_url . '.jpg') }}" alt="{{ $item->name }}" width="1563" height="1024" />
                    </picture>
                    <div class="product-single-recommend-box">
                        <p class="product-single-recommend-text_small">{{ $item->category->name }}</p>
                        <p class="product-single-recommend-text">{{ $item->name }}</p>
                        <p class="product-single-recommend-text_small">¥{{ number_format($item->price) }}-</p>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="c-button_backtolist">
                <div class="c-space"></div>
                <a href="{{ route('products.index') }}" class="c-button-slide">
                    <span class="c-button-slide-text">一覧へ</span>
                    <div class="c-button-slide-arrow">&gt;</div>
                </a>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')

{{-- ▼▼▼ JavaScript：スクロール制御とアニメーション制御 ▼▼▼ --}}
<script>
    // 1. スクロール位置を保存する関数
    function saveScrollPosition() {
        // 商品ページ用のキー名で保存
        localStorage.setItem('productScrollPosition', window.scrollY);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const notification = document.getElementById('cart-notification');
        
        // スクロール位置の復元
        const scrollPos = localStorage.getItem('productScrollPosition');
        if (scrollPos) {
            window.scrollTo(0, parseInt(scrollPos));
            localStorage.removeItem('productScrollPosition');
        }

        // メッセージがある場合のアニメーション処理
        if (notification) {
            // ① 描画タイミングをずらしてクラス付与（フェードイン）
            setTimeout(function() {
                notification.classList.add('is-visible');
            }, 100);

            // ② 5秒後にクラス削除（フェードアウト）
            setTimeout(function() {
                notification.classList.remove('is-visible');
                
                // ③ 完全に消えた後に非表示
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 600); 
            }, 5000);
        }
    });
</script>
{{-- ▲▲▲ JavaScriptここまで ▲▲▲ --}}