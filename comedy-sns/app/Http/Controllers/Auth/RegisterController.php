<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\RegisterUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationMail;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    
    public function sendMail(Request $request)
    {
        // 送られてきた内容のバリデーション
        $this->validator($request->all())->validate();

        // トークンを作成
        $token = $this->createToken();

        // 同じメールアドレスが残っていればテーブルから削除
        RegisterUser::destroy($request->email);

        // 送られてきた内容をテーブルに保存
        $passwordReset = new RegisterUser($request->all());
        $passwordReset->token = $token;
        $passwordReset->password = Hash::make($request->password);
        $passwordReset->save();

        // メールクラスでメールを送信
        $this->sendVerificationMail($passwordReset->email, $token);

        return $passwordReset;
    }

    use RegistersUsers;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:20'],
            'email' => [
            	'required', 'string', 'email', 'max:255', 
            	Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ]);
    }

    private function createToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    private function sendVerificationMail($email, $token)
    {
        Mail::to($email)->send(new VerificationMail($token));
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            ]);
        }
        
    protected function registered(Request $request, $user)
    {
       return $user;
    }
}
