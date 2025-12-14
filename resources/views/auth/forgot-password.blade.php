@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">パスワード再設定メール送信</h3>
                <div class="c-space c-space_hidden"></div>
            </div>

            <div class="contact-inner">
                {{-- 説明文 --}}
                <div class="c-message-box" style="margin-bottom: 30px;">
                    <p>
                        ご登録時のメールアドレスを入力してください。<br>
                        パスワード再設定用のリンクをメールでお送りします。
                    </p>
                </div>

                {{-- 送信成功メッセージ（「メールを送信しました」等） --}}
                @if (session('status'))
                    <div class="c-message-box" style="margin-bottom: 20px; color: green; font-weight: bold;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="c-form contact-list">
                    @csrf

                    <div class="c-form-item">
                        <label for="email">メールアドレス</label>
                        <input type="email" id="email" name="email" class="c-form-text" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="c-button c-button_small" type="submit">送信する</button>

                    <div style="text-align: center; margin-top: 30px;">
                        <a href="{{ route('login') }}" style="text-decoration: underline;">
                            ログイン画面へ戻る
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')