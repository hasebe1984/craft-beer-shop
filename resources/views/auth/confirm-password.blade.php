@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">パスワード確認</h3>
                <div class="c-space c-space_hidden"></div>
            </div>

            <div class="contact-inner">
                {{-- 説明文 --}}
                <div class="c-message-box" style="margin-bottom: 30px;">
                    <p>
                        セキュリティ保護のため、続行する前にパスワードを入力してください。
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="c-form contact-list">
                    @csrf

                    <div class="c-form-item">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" name="password" class="c-form-text" required autocomplete="current-password">
                        @error('password')
                            <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="c-button c-button_small" type="submit">確認する</button>
                </form>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')