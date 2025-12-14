@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">送信完了</h3>
                <div class="c-space c-space_hidden"></div>
            </div>
            
            <div class="contact-inner">
                <div class="c-message-box" style="text-align: center; margin-bottom: 40px;">
                    <p>お問い合わせいただきありがとうございます。<br>
                    ご入力いただいた内容は正常に送信されました。</p>
                    <br>
                    <p>担当者より折り返しご連絡させていただきますので、<br>
                    今しばらくお待ちください。</p>
                </div>

                {{-- TOPへ戻るボタン配置（CSSクラスは既存のものを流用） --}}
                <div style="text-align: center;">
                    <a href="{{ route('home') }}" class="c-button c-button_small">
                        トップページへ戻る
                    </a>
                </div>

                {{-- 必要であればナビゲーションを残す --}}
                <div class="c-nav c-nav_hidden">
                    <ul class="c-nav-list">
                        <li><a href="contact.html">お問い合わせ</a></li>
                        <li><a href="privacy.html">プライバシーポリシー</a></li>
                        <li><a href="tokushoho.html">特商法に基づく表記</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    </main>
@include('partials.footer')