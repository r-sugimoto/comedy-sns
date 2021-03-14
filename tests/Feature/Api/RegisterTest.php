<?php

namespace Tests\Feature\Api;

use App\RegisterUser;
use App\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
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

        factory(User::class)->create([
            'email' => 'foo@email.com',
        ]);
    }
    public function test_仮会員登録_メールアドレスバリデーションエラー_失敗()
    {
        // フォームから送信するデータ
        $data = [
            'name' => 'test',
            'email' => 'foo@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
    }
    
    public function test_仮会員登録_正常()
    {
        // 送信するデータ
        $data = [
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $data);
        $response->assertStatus(201)
        ->assertJsonFragment([
                'email' => 'test@email.com',
                'name' => 'test',
        ]);
    }
}
