<?php

namespace Tests\Feature\Api;

use App\RegisterUser;
use App\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        // 仮会員登録ダミーデータ作成
        $this->register_user = factory(RegisterUser::class)->create([
            'email' => 'samantha.doyle@example.net',
            'token' => '130c9275efd05b4d0bed20ded58d16cc46fcb9e237d5bb9c970fff02365187f6'
        ]);
    }

    public function test_存在しないトークンの受け取り_本会員登録_失敗()
    {
        // トークン取得
        $response = $this->get('/verification/413o24hi32j4324hio324i12j4i2i4u8-0bgqo3ptjdspokjgo');
        // 仮会員登録に存在しないトークンであれば、ログインページに遷移する
        $response->assertRedirect('login');
        $response->assertStatus(302);
    }

    public function test_トークンの受け取り_本会員登録_正常()
    {
        // トークン取得
        $response = $this->get('/verification/130c9275efd05b4d0bed20ded58d16cc46fcb9e237d5bb9c970fff02365187f6');
        // 本会員登録チェック
        // 仮会員登録情報を削除
        $register_user = RegisterUser::where('email', $this->register_user->email)->first();
        $this->assertNull($register_user);
        // 本会員登録
        $user = User::where('email', $this->register_user->email)->first();
        $this->assertNotNull($user);
        // 仮会員登録に存在するトークンであれば、ダッシュボードページに遷移する
        $response->assertRedirect('dashboard');
        $response->assertStatus(302);
    }
}
