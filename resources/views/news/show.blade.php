@include('partials.header')
<main>
    <section class="news-single l-section-top">
        {{-- メイン画像 --}}
        <picture class="news-single-thumbnail">
            <source srcset="{{ asset($post->image_url . '.webp') }}" type="image/webp" />
            <img src="{{ asset($post->image_url . '.jpg') }}" alt="{{ $post->title }}" width="1563" height="1024" />
        </picture>

        <div class="news-single-info">
            {{-- タイトル --}}
            <h1 class="c-card-title">{{ $post->title }}</h1>
            <div class="news-single-info-box">
                {{-- カテゴリー名 --}}
                <p class="c-card-data">{{ $post->category->name }}</p>
                {{-- 日付（Y年m月d日形式に変換） --}}
                <p class="c-card-data">{{ $post->published_at ? $post->published_at->format('Y年m月d日') : '' }}</p>
            </div>
        </div>

        <div class="news-single-box">
            <div class="news-single-article">
                {{-- 
                    ★本文エリア
                    データベースのHTMLをそのまま出力するため {!! !!} を使用します。
                    ※注意: DB内のデータがテキストのみの場合、今回いただいたサンプルのような
                    表や見出しのデザインは反映されません。管理画面等でHTMLを入力する必要があります。
                --}}
                {!! $post->content !!}
                
                {{-- 
                   （補足）もしDBデータに関わらず、今回いただいた「ライアン・マーフィー」のHTMLを
                   そのまま固定で表示したい場合は、{!! $post->content !!} を削除し、
                   ここに元のHTMLを貼り付けてください。
                --}}
                
                <div class="news-single-article-signature">
                    — ホップ中毒者より愛を込めて
                </div>
            </div>

            {{-- サイドバー（カテゴリーリスト） --}}
            <div class="c-nav">
                <h4 class="c-nav-title">カテゴリー</h4>
                <div class="c-nav-list">
                    @foreach ($categories as $category)
                    <div class="c-nav-checkbox">
                        {{-- クリックすると一覧ページへ飛び、そのカテゴリで絞り込む --}}
                        <a href="{{ url('/news') }}?categories[]={{ $category->slug }}" style="text-decoration: none; width: 100%;">
                            <label style="pointer-events: none;">{{ $category->name }}</label>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="c-space c-space_primary c-space_img"></div>

        <div class="news-single-recommend">
            <p class="c-nav-title">関連記事</p>
            <div class="news-single-recommend-container">
                {{-- 関連記事がない場合 --}}
                @if($related_posts->isEmpty())
                    <p>同じカテゴリの関連記事はありません。</p>
                @else
                    {{-- 関連記事を表示 --}}
                    @foreach($related_posts as $related)
                    <a href="{{ route('news.show', $related->id) }}" class="news-single-recommend-item">
                        <picture>
                            <source srcset="{{ asset($related->image_url . '.webp') }}" type="image/webp" />
                            <img src="{{ asset($related->image_url . '.jpg') }}" alt="{{ $related->title }}" width="1563" height="1024" />
                        </picture>
                        <div class="news-single-recommend-box">
                            {{-- ここにカテゴリ名が表示されます --}}
                            <div class="news-single-recommend-text news-single-recommend-text_small">
                                {{ $related->category->name }}
                            </div>
                            <div class="news-single-recommend-text">{{ $related->title }}</div>
                        </div>
                    </a>
                    @endforeach
                @endif
            </div>

            <div class="c-button_backtolist">
                <div class="c-space"></div>
                <a href="{{ url('/news') }}" class="c-button-slide">
                    <span class="c-button-slide-text">一覧へ</span>
                    <div class="c-button-slide-arrow">&gt;</div>
                </a>
            </div>
        </div>
    </section>
    </main>
@include('partials.footer')