@section('title', 'Products')
@include('partials.header')

<main>
    <section class="product l-section-top">
        <div class="c-title-level2-wrap c-title-level2-wrap_news">
            <h2 class="c-title-level2">product</h2>
        </div>
        <div class="product-container">
            
            {{-- ▼ 商品リストエリア ▼ --}}
            <div class="c-card2-list">
                @if($products->isEmpty())
                    <p class="c-card2-text">該当する商品はありません。</p>
                @endif

                @foreach ($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="c-card2">
                    <picture class="c-card2-thumbnail">
                        <source srcset="{{ asset($product->image_url . '.webp') }}" media="(min-width: 769px)" type="image/webp" />
                        <img src="{{ asset($product->image_url . '.jpg') }}" alt="{{ $product->name }}" width="1563" height="1024" />
                    </picture>
                    <div class="c-card2-box">
                        <div>
                            <p class="c-card2-name">{{ $product->name }}</p>
                            <p class="c-card2-category">{{ $product->category->name }}</p>
                        </div>
                        {{-- number_formatで3桁区切り --}}
                        <p class="c-card2-price">¥{{ number_format($product->price) }}-</p>
                    </div>
                </a>
                @endforeach
                
                {{-- ▼ ページネーション（Laravel標準） ▼ --}}
                <div style="margin-top: 2rem; width: 100%;">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>

            {{-- ▼ サイドバー（カテゴリ検索） ▼ --}}
            <nav class="c-nav">
                <h4 class="c-nav-title">カテゴリー</h4>
                
                {{-- GETメソッドで自分自身（/products）に送信 --}}
                <form action="{{ route('products.index') }}" method="GET" class="c-nav-list">
                    @foreach ($categories as $category)
                    <div class="c-nav-checkbox">
                        {{-- js-auto-submit クラスで自動送信（common.jsが必要） --}}
                        <input type="checkbox" 
                               id="cat-{{ $category->id }}" 
                               name="categories[]" 
                               value="{{ $category->id }}" 
                               class="js-auto-submit"
                               @if(in_array($category->id, request()->input('categories', []))) checked @endif
                        />
                        <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </form>
            </nav>
        </div>
    </section>
</main>
@include('partials.footer')
{{-- 自動送信用のJSを読み込み --}}
<script src="{{ asset('js/common.js') }}"></script>