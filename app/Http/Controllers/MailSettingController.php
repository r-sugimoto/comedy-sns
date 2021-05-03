<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\MailSetting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SettingMail;

class MailSettingController extends Controller
{
    public function setting(Request $request)
    {
        // 送られてきた内容のバリデーション
        $this->validator($request->all())->validate();
        $token = $this->createToken();
        MailSetting::destroy($request->email);
        $setting = new MailSetting();
        $setting->email = $request->email;
        $setting->token = $token;
        $setting->user_id = Auth::user()->id;
        $setting->save();
        Mail::to($setting->email)->send(new SettingMail($token));
        return $setting;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => [
            	'required', 'string', 'email', 'max:255', 
            	Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
        ]);
    }

    private function createToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    // vueでアクセスするホームへのルート
    protected $vueRouteHome = 'setting';
    // vueでアクセスするログインへのルート
    protected $vueRouteLogin = 'login';

    public function settingEmail($token){
        $setting = MailSetting::where('token', $token)->first();
        if(!$setting){
            MailSetting::destroy($setting->email);
        }else{
            $message = 'メールの設定に失敗しました。';
            return $this->redirectWithMessage($this->vueRouteLogin, $message);
        }


    }

    protected function redirectWithMessage($vueRoute, $message)
    {
        // ログイン後のURL
        $route = url($vueRoute);

        return redirect($route)->cookie('MESSAGE', $message, 0, '', '', false, false);
    }
}
