@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">パスワード再設定</h3>
                <div class="c-space c-space_hidden"></div>
            </div>

            <div class="contact-inner">
                <form method="POST" action="{{ route('password.store') }}" class="c-form contact-list">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="c-form-item">
                        <label for="email">メールアドレス</label>
                        <input type="email" id="email" name="email" class="c-form-text" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                        @error('email')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item">
                        <label for="password">新しいパスワード</label>
                        <input type="password" id="password" name="password" class="c-form-text" required autocomplete="new-password">
                        @error('password')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="c-form-item">
                        <label for="password_confirmation">新しいパスワード（確認用）</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="c-form-text" required autocomplete="new-password">
                        @error('password_confirmation')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="c-button c-button_small" type="submit">パスワードを再設定する</button>
                </form>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')