@extends('layouts.mail')

    @section('title', '登録認証')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Comenion運営事務局でございます。<br>Comenionに登録いただき誠にありがとうございます。<br><br></div>

                    <div class="card-body">
                        <a href='{{$url}}'>こちらのリンク</a>をクリックして、メールを認証してください。<br><br>
                        ※当メールは送信専用メールアドレスから配信されています。<br>
                        このままご返信いただいてもお答えできませんのでご了承ください。<br><br>
                        ※当メールに心当たりの無い場合は、誠に恐れ入りますが破棄して頂けますよう、よろしくお願い致します。<br><br>
                        Comenion運営事務局<br>
                        お問い合わせは<a href='https://ryu-nosu.com/contact/'>こちら</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection