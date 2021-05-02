<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\MailSetting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
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
}
