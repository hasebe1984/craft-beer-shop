@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">ログイン</h3>
                <div class="c-space c-space_hidden"></div>
            </div>

            <div class="contact-inner">
                {{-- ステータス表示 --}}
                @if (session('status'))
                    <div class="c-message-box" style="margin-bottom: 20px; color: green;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="c-form contact-list">
                    @csrf

                    <div class="c-form-item">
                        <label for="email">メールアドレス</label>
                        <input type="email" id="email" name="email" class="c-form-text" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" name="password" class="c-form-text" required autocomplete="current-password">
                        @error('password')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item c-form-item_row">
                        <input type="checkbox" id="remember_me" name="remember" class="c-form-checkbox">
                        <label for="remember_me">次回から自動的にログインする</label>
                    </div>

                    <button class="c-button c-button_small" type="submit">ログイン</button>

                    <div style="text-align: center; margin-top: 30px; line-height: 2;">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="text-decoration: underline;">
                                パスワードをお忘れの方はこちら
                            </a><br>
                        @endif
                        <a href="{{ route('register') }}" style="text-decoration: underline;">
                            新規会員登録はこちら
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')