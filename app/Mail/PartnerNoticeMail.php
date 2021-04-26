<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerNoticeMail extends Mailable
    {
        use Queueable, SerializesModels;

        protected $name;

        public function __construct($name)
        {
            // 引数でトークンを受け取る
            $this->name = $name;
        }

        // メール作成
        public function build()
        {
           $name = $this->name;
           // 件名
           $subject = "【Comenion】{$name}さんから相方申請が届いています";

            // .envの「APP_URL」に設定したurlを取得
            $baseUrl = config('app.url');
            $url = "{$baseUrl}";

           // 送信元のアドレス
           $from = config('mail.from.address');

            // メール送信
            return $this
              ->from($from)
              ->subject($subject)
              // 送信メールのビュー
              ->view('mails.partner_mail')
              // ビューで使う変数を渡す
              ->with('url', $url)
              ->with('name', $name);
        }
    }
