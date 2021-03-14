<?php

namespace Tests\Feature\Api;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // ユーザー作成
        $this->user = factory(User::class)->create();
    }

    public function test_ログアウト_正常()
    {
        // ログイン状態にする
        $response = $this->actingAs($this->user);
        $response= $this->postJson('api/logout');

        $response->assertStatus(200);

        // 認証されていないことを確認
        $this->assertGuest();
    }
}
