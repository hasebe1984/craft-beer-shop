<!DOCTYPE html>
<html lang="ja">
<body>
    <p>ウェブサイトのお問い合わせフォームより、以下の連絡がありました。</p>

    <p>
        【お名前】<br>
        {{ $inputs['name'] }}
    </p>

    <p>
        【メールアドレス】<br>
        {{ $inputs['email'] }}
    </p>

    <p>
        【電話番号】<br>
        {{ $inputs['tel'] ?? 'なし' }}
    </p>

    <p>
        【お問い合わせ内容】<br>
        {!! nl2br(e($inputs['message'])) !!}
    </p>
    {{-- エラーメッセージ表示エリア --}}
    @if ($errors->any())
    <div class="c-message-box c-message-box_error" style="color: red; margin-bottom: 20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</body>
</html>