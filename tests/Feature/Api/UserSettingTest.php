<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSettingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // ユーザー情報のダミーデータ作成
        $this->user = factory(User::class)->create([
            'name' => 'テストユーザー',
            'age' => 20,
            'published_age_flg' => 1,
            'prefecture_id' => 1,
            'published_age_flg' => 1,
            'introduction' => 'これはテストですテストです',
        ]);
    }


    public function test_ユーザー設定情報取得_正常()
    {
        // ダーミーデーターを認証させる
        $this->actingAs($this->user);

        $response = $this->getJson('/api/user/setting');
        $response->assertStatus(200)
        ->assertJsonFragment([
            'name' => 'テストユーザー',
            'age' => 20,
            'published_age_flg' => 1,
            'prefecture_id' => 1,
            'published_age_flg' => 1,
            'introduction' => 'これはテストですテストです',
        ]);
    }

    public function test_ユーザー設定情報更新_バリデーションエラー_ファイルサイズ_失敗()
    {
        // ダーミーデーターを認証させる
        $this->actingAs($this->user);
        
        // ダミー画像作成　50MB バリデーションは2MBまで
        $file = UploadedFile::fake()->image('avatar.jpg')->size(50000);

        $data = [
            'name' => 'テストだよー',
            'picture_file' => $file,
        ];

        $response = $this->postJson('/api/user/setting', $data);
        $response->assertStatus(422);
    }

    public function test_ユーザー設定情報更新_正常()
    {
        // ダーミーデーターを認証させる
        $this->actingAs($this->user);

        // ダミー画像作成　50MB バリデーションは2MBまで
        $file = UploadedFile::fake()->image('avatar.jpg')->size(2000);

        $data = [
            'name' => 'テストだよー',
            'age' => 26,
            'published_age_flg' => 0,
            'prefecture_id' => 15,
            'published_age_flg' => 0,
            'introduction' => '更新しましたよー',
            'picture_file' => $file,
        ];

        $response = $this->postJson('/api/user/setting', $data);
        $response->assertStatus(200);
    }




}
