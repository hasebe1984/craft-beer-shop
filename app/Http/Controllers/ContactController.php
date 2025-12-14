<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSendMail; // 後ほど作成するMailableクラス

class ContactController extends Controller
{
    /**
     * お問い合わせ入力画面表示
     */
    public function index()
    {
        // resources/views/contact/index.blade.php を呼ぶ場合
        return view('contact.index');
    }

    /**
     * 送信処理
     */
    public function send(Request $request)
    {
        // 1. バリデーション（入力チェック）
        // View側の name 属性と一致させます
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'tel'       => 'nullable|numeric|digits_between:10,11', // 電話番号は任意、数値のみ
            'message'   => 'required|string|max:2000',
            'agreement' => 'accepted', // チェックボックス必須
        ], [
            // エラーメッセージの日本語化（任意）
            'name.required'      => 'お名前を入力してください。',
            'email.required'     => 'メールアドレスを入力してください。',
            'email.email'        => '正しいメールアドレス形式で入力してください。',
            'tel.numeric'        => '電話番号は数字で入力してください。',
            'message.required'   => 'お問い合わせ内容を入力してください。',
            'agreement.accepted' => '利用規約への同意が必要です。',
        ]);

        // 2. メール送信処理
        // 管理者へ届くメール
        // 実際には .env で MAIL_FROM_ADDRESS などを設定しておく必要があります
        // まだMailableクラスがない場合は、ここをコメントアウトして動作確認してください

        // Mail::to('admin@example.com')->send(new ContactSendMail($validated));

        // ユーザーへの自動返信メールを送る場合も同様に記述します


        // 3. 二重送信防止のため、完了画面へリダイレクト
        return redirect()->route('contact.complete');
    }

    /**
     * お問い合わせ完了画面表示
     */
    public function complete()
    {
        // 完了画面も同じフォルダ構成にするのが一般的です
        // ファイル場所: resources/views/contact/complete.blade.php
        return view('contact.complete');
    }
}
