<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\RegisterUser;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    // vueでアクセスするホームへのルート
    protected $vueRouteHome = 'dashboard';
    // vueでアクセスするログインへのルート
    protected $vueRouteLogin = 'login';

    // トークンから仮登録情報取得する
    public function register($token)
    {
        // 仮登録のデータをトークンで取得
        $registerUser = $this->getRegisterUser($token);

        // 取得できなかった場合
        if (!$registerUser) {

            // 失敗メッセージを作成
            $message = '登録に失敗しました。';

            // メッセージをつけてリダイレクト
            return $this->redirectWithMessage($this->vueRouteLogin, $message);
        }

        // 仮登録のデータでユーザを作成
        event(new Registered($user = $this->createUser($registerUser->toArray())));

        // 作成したユーザをログインさせる
        Auth::login($user, true);

        // 成功メッセージ
        $message = '登録完了しました。';

        // メッセージをつけてリダイレクト
        return $this->redirectWithMessage($this->vueRouteHome, $message);
    }

    private function getRegisterUser($token)
    {
        // トークンで仮登録ユーザデータを取得
        $registerUser = RegisterUser::where('token', $token)->first();

        // 取得できた場合は仮登録データを削除
        if ($registerUser) {
            RegisterUser::destroy($registerUser->email);
        }

        // モデルを返す
        return $registerUser;
    }

    // ユーザー作成
    protected function createUser(array $data)
    {
        $user = User::where("email", $data['email'])->first();
        if(!empty($user)){
            $user = User::onlyTrashed()->where("email", $data['email'])
            ->update(['name' => $data['name'], 'password' => $data['password'], 'deleted_at' => NULL]);
            return $user;
        }else{
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => Carbon::now(),
                'password' => $data['password'],
            ]);
            return $user;

        }
    }

    protected function redirectWithMessage($vueRoute, $message)
    {
        // ログイン後のURL
        $route = url($vueRoute);

        return redirect($route)->cookie('MESSAGE', $message, 0, '', '', false, false);
    }
}
