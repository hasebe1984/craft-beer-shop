@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">メールアドレスの確認</h3>
                <div class="c-space c-space_hidden"></div>
            </div>

            <div class="contact-inner">
                {{-- 案内メッセージ --}}
                <div class="c-message-box" style="margin-bottom: 30px;">
                    <p>
                        ご登録ありがとうございます。<br>
                        ご入力いただいたメールアドレスに確認用リンクを送信しました。<br>
                        メール内のリンクをクリックして、登録を完了してください。
                    </p>
                    <p style="font-size: 0.9em; margin-top: 10px; color: #666;">
                        ※メールが届かない場合は、迷惑メールフォルダをご確認いただくか、<br>
                        以下のボタンから再送信してください。
                    </p>
                </div>

                {{-- 再送信完了メッセージ --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="c-message-box" style="margin-bottom: 20px; color: green; font-weight: bold;">
                        新しい確認用リンクを送信しました。
                    </div>
                @endif

                <div class="c-form contact-list">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div style="text-align: center; margin-bottom: 20px;">
                            <button class="c-button c-button_small" type="submit">確認メールを再送信する</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div style="text-align: center;">
                            <button type="submit" style="background: none; border: none; text-decoration: underline; cursor: pointer; color: #333;">
                                ログアウト
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@include('partials.footer')