@section('title', 'ショッピングカート')
@include('partials.header')

{{-- ▼▼▼ 共通メッセージ（修正箇所：classを追加！） ▼▼▼ --}}
@if(session('success'))
    <div id="cart-notification" class="cart-notification">
        {{ session('success') }}
    </div>
@endif
{{-- ▲▲▲ 共通メッセージここまで ▲▲▲ --}}

<main>
    <section class="l-section-top" style="max-width: 1000px; margin: 0 auto; padding: 4rem 2rem;">
        <h2 class="c-title-level2" style="margin-bottom: 2rem;">SHOPPING CART</h2>

        @if(empty($cart) || count($cart) == 0)
            <p>カートに商品は入っていません。</p>
            <div style="margin-top: 2rem;">
                <a href="{{ url('/products') }}" class="c-button-slide" style="display:inline-flex;">
                    <span class="c-button-slide-text">買い物を続ける</span>
                </a>
            </div>
        @else
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
                <thead>
                    <tr style="border-bottom: 1px solid #ddd; text-align: left;">
                        <th style="padding: 1rem;">商品</th>
                        <th style="padding: 1rem;">価格</th>
                        <th style="padding: 1rem;">数量</th>
                        <th style="padding: 1rem;">小計</th>
                        <th style="padding: 1rem;">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                    @php 
                        $subtotal = $details['price'] * $details['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;">
                            <a href="{{ route('products.show', $id) }}" style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit;">
                                <img src="{{ asset($details['image_url'] . '.jpg') }}" width="60" height="60" style="object-fit: cover; border-radius: 4px;">
                                <div>
                                    <div style="font-size: 0.8rem; color: #888;">{{ $details['category_name'] }}</div>
                                    <div>{{ $details['name'] }}</div>
                                </div>
                            </a>
                        </td>
                        <td style="padding: 1rem;">¥{{ number_format($details['price']) }}</td>
                        
                        {{-- 数量変更 --}}
                        <td style="padding: 1rem;">
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="product-single-stepper" style="transform: scale(0.8); transform-origin: left center;">
                                    <button type="button" aria-label="数量を減らす" 
                                        onclick="this.nextElementSibling.stepDown(); saveScrollPosition(); this.form.submit();">
                                        -
                                    </button>
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="99" inputmode="numeric" readonly />
                                    <button type="button" aria-label="数量を増やす" 
                                        onclick="this.previousElementSibling.stepUp(); saveScrollPosition(); this.form.submit();">
                                        +
                                    </button>
                                </div>
                            </form>
                        </td>

                        <td style="padding: 1rem;">¥{{ number_format($subtotal) }}</td>
                        
                        {{-- 削除ボタン --}}
                        <td style="padding: 1rem;">
                            <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                @csrf
                                <button type="submit" style="color: red; background: none; border: none; cursor: pointer; text-decoration: underline;" onclick="saveScrollPosition()">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align: right; margin-bottom: 3rem;">
                <h3 style="font-size: 1.5rem;">合計: ¥{{ number_format($total) }}</h3>
                <div style="margin-top: 2rem;">
                    <button class="c-button-slide" style="display:inline-flex;">
                        <span class="c-button-slide-text">レジへ進む</span>
                    </button>
                </div>
            </div>
        @endif
    </section>
</main>
@include('partials.footer')

{{-- ▼▼▼ JavaScript：スクロール復元とクラス切り替え ▼▼▼ --}}
<script>
    function saveScrollPosition() {
        localStorage.setItem('cartScrollPosition', window.scrollY);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const notification = document.getElementById('cart-notification');
        
        // スクロール位置の復元
        const scrollPos = localStorage.getItem('cartScrollPosition');
        if (scrollPos) {
            window.scrollTo(0, parseInt(scrollPos));
            localStorage.removeItem('cartScrollPosition');
        }

        // アニメーション制御
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