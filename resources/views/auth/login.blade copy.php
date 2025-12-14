@include('partials.header')

<main>
    <section class="l-section-top">
        <div class="c-title-level2-wrap">
            <h2 class="c-title-level2">LOGIN</h2>
        </div>

        <div class="c-container-narrow">
            <form method="POST" action="{{ route('login') }}" class="c-form">
                @csrf @if ($errors->any())
                    <div style="color: red; margin-bottom: 1rem; text-align: center;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="c-form-item">
                    <label for="email" class="c-form-label">メールアドレス</label>
                    <input type="email" id="email" name="email" class="c-form-input" 
                           value="{{ old('email') }}" required autofocus placeholder="例: yamada@example.com">
                </div>

                <div class="c-form-item">
                    <label for="password" class="c-form-label">パスワード</label>
                    <input type="password" id="password" name="password" class="c-form-input" 
                           required autocomplete="current-password">
                </div>

                <div class="c-form-check">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">ログイン状態を保存する</label>
                </div>

                <div class="c-button-wrap">
                    <button type="submit" class="c-button c-button_primary">
                        ログイン
                    </button>
                </div>

                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ route('register') }}" style="text-decoration: underline;">
                        新規会員登録はこちら
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>

@include('partials.footer')

{{-- 簡易的なCSS（もし崩れていたら style.css に移動させてください） --}}
<style>
    .c-container-narrow {
        max-width: 600px;
        margin: 0 auto;
        padding: 4rem 1rem;
    }
    .c-form-item {
        margin-bottom: 1.5rem;
    }
    .c-form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    .c-form-input {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .c-button-wrap {
        margin-top: 2rem;
        text-align: center;
    }
    .c-button_primary {
        background-color: #333;
        color: #fff;
        padding: 1rem 3rem;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }
</style>