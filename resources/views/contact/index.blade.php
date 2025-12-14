@section('title', 'お問い合わせ')
@include('partials.header')
<main>
    <section class="contact l-section-top">
        <div class="contact-outer">
            <div class="c-title-level3-wrap">
                <h3 class="c-title-level3">お問い合わせ</h3>
                <div class="c-space c-space_hidden"></div>
            </div>
            <div class="contact-inner">
                {{-- formタグに method と action を追加 --}}
                <form action="{{ route('contact.submit') }}" method="POST" class="c-form contact-list">
                    @csrf {{-- Laravelのセキュリティ対策 --}}

                    <div class="c-form-item">
                        <label for="name">お名前</label>
                        {{-- idとnameを追加 --}}
                        <input type="text" id="name" name="name" class="c-form-text" required>
                    </div>

                    <div class="c-form-item">
                        <label for="email">メールアドレス</label>
                        {{-- type="email", id, nameを追加 --}}
                        <input type="email" id="email" name="email" class="c-form-text" required>
                    </div>

                    <div class="c-form-item">
                        <label for="tel">電話番号</label>
                        {{-- type="tel", id, nameを追加 --}}
                        <input type="tel" id="tel" name="tel" class="c-form-text">
                    </div>

                    <div class="c-form-item">
                        <label for="message">お問い合わせ内容</label>
                        {{-- idを追加 --}}
                        <textarea name="message" id="message" class="c-form-textarea" required></textarea>
                    </div>

                    <div class="c-form-item c-form-item_row">
                        {{-- チェックボックスにidをつけ、ラベルと紐付け --}}
                        <input type="checkbox" name="agreement" id="agreement" class="c-form-checkbox" required>
                        <label for="agreement">利用規約に同意する</label>
                    </div>

                    {{-- type="button" だと送信されないため submit に変更 --}}
                    <button class="c-button c-button_small" type="submit">送信する</button>
                </form>

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