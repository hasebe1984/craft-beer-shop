@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">新規会員登録</h3>
                <div class="c-space c-space_hidden"></div>
            </div>

            <div class="contact-inner">
                <form method="POST" action="{{ route('register') }}" class="c-form contact-list">
                    @csrf

                    <div class="c-form-item">
                        <label for="name">お名前</label>
                        <input type="text" id="name" name="name" class="c-form-text" value="{{ old('name') }}" required autofocus autocomplete="name">
                        @error('name')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item">
                        <label for="email">メールアドレス</label>
                        <input type="email" id="email" name="email" class="c-form-text" value="{{ old('email') }}" required autocomplete="username">
                        @error('email')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" name="password" class="c-form-text" required autocomplete="new-password">
                        @error('password')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item">
                        <label for="password_confirmation">パスワード（確認用）</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="c-form-text" required autocomplete="new-password">
                        @error('password_confirmation')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="c-button c-button_small" type="submit">登録する</button>

                    <div style="text-align: center; margin-top: 30px;">
                        <a href="{{ route('login') }}" style="text-decoration: underline;">
                            既に登録済みの方はこちら（ログイン）
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')