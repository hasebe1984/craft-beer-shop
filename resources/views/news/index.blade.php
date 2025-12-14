@include('partials.header')
<main>
    <section class="l-section-top">
        <div class="c-title-level2-wrap c-title-level2-wrap_news">
            <h2 class="c-title-level2">news</h2>
        </div>
        <div class="news-container">
            
            <div class="c-card-list">
                @if($posts->isEmpty())
                    <p style="padding: 2rem;">該当する記事はありません。</p>
                @endif

                @foreach ($posts as $post)
                <article>
                    <a href="{{ route('news.show', $post->id) }}" class="c-card">
                        <picture class="c-card-thumbnail">
                            <source srcset="{{ asset($post->image_url . '.webp') }}" media="(min-width: 769px)"
                                type="image/webp" />
                            <img src="{{ asset($post->image_url . '.jpg') }}" alt="{{ $post->title }}" width="1536"
                                height="1024" />
                        </picture>
                        <div class="c-card-box">
                            <div class="c-card-wrap">
                                <span class="c-card-tab">{{ $post->category->name }}</span>
                                <p class="c-card-data">{{ $post->published_at }}</p>
                            </div>
                            <p class="c-card-title">{{ $post->title }}</p>
                            <p class="c-card-description">{{ $post->excerpt }}</p>
                        </div>
                    </a>
                </article>
                @endforeach

                <div class="c-pagination-wrap">
                    {{ $posts->links() }}
                </div>
                </div>

            <nav class="c-nav">
                <h4 class="c-nav-title">カテゴリー</h4>
                
                <form action="{{ url('/news') }}" method="GET" class="c-nav-list">
                    
                    @foreach ($categories as $category)
                    <div class="c-nav-checkbox">
                        {{-- 
                            ★汎用化のポイント：
                            class="js-auto-submit" を追加しました。
                            これでJSファイルが「これを変更したら送信するんだな」と認識します。
                        --}}
                        <input type="checkbox" 
                               id="{{ $category->slug }}" 
                               name="categories[]" 
                               value="{{ $category->slug }}"
                               class="js-auto-submit" 
                               @if(in_array($category->slug, request()->input('categories', []))) checked @endif
                        />
                        <label for="{{ $category->slug }}">{{ $category->name }}</label>
                    </div>
                    @endforeach

                </form>
            </nav>

        </div>
    </section>
</main>
@include('partials.footer')