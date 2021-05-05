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
    public function index(){
        $user = User::select("email", "thumbnail")->where("id", Auth::user()->id)->first();
        return $user;
    }

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
    protected $vueRouteSetting = 'setting';
    // vueでアクセスするログインへのルート
    protected $vueRouteHome = 'dashboard';

    public function settingEmail($token){
        $setting = MailSetting::where('token', $token)->first();
        if(!$setting){
            $message = [
                'message' => 'メールの設定に失敗しました。',
                // 成功:0 失敗:１
                'flg' => 1,
            ];
            return $this->redirectWithMessage($this->vueRouteHome, $message);
        }

        MailSetting::destroy($setting->email);
        $user = User::find($setting->user_id);
        $user->email = $setting->email;
        $user->update();
        $message = [
            'message' => 'メールの設定に成功しました。',
            // 成功:0 失敗:１
            'flg' => 0,
        ];
        Auth::login($user, true);
        return $this->redirectWithMessage($this->vueRouteSetting, $message);
    }

    protected function redirectWithMessage($vueRoute, $message)
    {
        // ログイン後のURL
        $route = url($vueRoute);

        $message = json_encode($message);

        return redirect($route)->cookie('MESSAGE', $message, 0, '', '', false, false);
    }
}
