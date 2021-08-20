<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    // vueでアクセスするホームへのルート
    protected $vueRouteHome = 'dashboard';
    // vueでアクセスするログインへのルート
    protected $vueRouteLogin = 'login';

    public function redirectToTwitterProvider(){
        return Socialite::driver('twitter')->redirect()->getTargetUrl();
    }

    public function handleTwitterProviderCallback(){

        try {
            $twitterUser = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            $message = 'twitter認証に失敗しました。';
            return $this->redirectWithMessage($this->$vueRouteLogin, $message);
        }

        $user = User::where('provider', 'twitter')->where('provider_id', $twitterUser->getId())->first();
        
        if (!empty($user)) {
            Auth::login($user, true);
            $message = 'ログインしました。';
            return $this->redirectWithMessage($this->vueRouteHome, $message);
        } else {
            $user = User::create([
                'name' => $twitterUser->getName(),
                'provider' => 'twitter',
                'provider_id' => $twitterUser->getId()
            ]);

            Auth::login($user, true);
            $message = '登録完了しました。';
            return $this->redirectWithMessage($this->vueRouteHome, $message);
        }
    }

    protected function redirectWithMessage($vueRoute, $message)
    {
        // ログイン後のURL
        $route = url($vueRoute);
        return redirect($route)->cookie('MESSAGE', $message, 0, '', '', false, false);
    }
}
