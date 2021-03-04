<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
    {
        use Queueable, SerializesModels;

        protected $token;

        public function __construct($token)
        {
            // 引数でトークンを受け取る
            $this->token = $token;
        }

        // メール作成
        public function build()
        {
           // 件名
           $subject = '仮登録受付完了';

            // .envの「APP_URL」に設定したurlを取得
            $baseUrl = config('app.url');
            $token = $this->token;
            $url = "{$baseUrl}/verification/{$token}";

           // 送信元のアドレス
           $from = config('mail.from.address');

            // メール送信
            return $this
              ->from($from)
              ->subject($subject)
              // 送信メールのビュー
              ->view('mails.verification_mail')
              // ビューで使う変数を渡す
              ->with('url', $url);
        }
    }
