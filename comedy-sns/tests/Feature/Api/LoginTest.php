<?php

namespace Tests\Feature\Api;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // ユーザー作成
        $this->user = factory(User::class)->create();
    }
    public function test_ログイン_バリデーションエラー_存在しないデータ_失敗()
    {
        // フォームから送信するデータ
        $data = [
            'email' => 'test' . $this->user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(422);
    }
    
    public function test_ログイン_正常()
    {
        // 認証されていないことを確認
        $this->assertGuest();

        // 送信するデータ
        $data = [
            'email' => $this->user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $data);
        $response->assertStatus(200);

        // 認証確認
        $this->assertAuthenticatedAs($this->user);
    }
}

