<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inputs; // フォームからの入力データ

    /**
     * コンストラクタでデータを受け取る
     */
    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * メールの構築
     */
    public function build()
    {
        return $this
            ->subject('ウェブサイトよりお問い合わせがありました') // メールの件名
            ->view('emails.contact_admin'); // メール本文のViewファイル
    }
}
