<?php

namespace Tests\Unit\Request;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateUserSettingRequest;

class UpdateUserSettingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * カスタムリクエストのバリデーションテスト
     *
     * @param string 項目名
     * @param string 値
     * @param boolean 期待値(true:バリデーションOK、false:バリデーションNG)
     * @dataProvider dataproviderExample
     */
    public function test_UpdateUserSettingRequest($item, $data, $expect)
    {
        //dataを格納する
        $dataList = [$item => $data];
        $request = new UpdateUserSettingRequest();
        //定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($dataList, $rules);
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        $result = $validator->passes();
        //期待値と結果を比較する
        $this->assertEquals($expect, $result);
    }

    public function dataproviderExample()
    {
        $file_1 = UploadedFile::fake()->image('avatar.jpg')->size(5000);
        $file_2 = UploadedFile::fake()->image('avatar.jpg')->size(5001);
        $file_2 = UploadedFile::fake()->create('document.pdf');

        return [
            '正常' => ['picture_file', $file_1, true],
            'ファイルサイズエラー' => ['picture_file', $file_2, false],
            '形式エラー' => ['picture_file', $file_3, false],
        ];
    }
}
