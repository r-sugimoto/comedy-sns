<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api')->group(function () {
    // トークンリフレッシュ
    Route::get('/reflesh-token', function (Illuminate\Http\Request $request) {
        $request->session()->regenerateToken();
        return response()->json();
    });
    // 会員登録メール作成
    Route::post('/register', 'Auth\RegisterController@sendMail')->name('register');
    // ログイン
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    // ログアウト
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('user', fn () => Auth::user())->name('user');

    // ユーザー情報設定ページ
    Route::get('/user/setting', 'UserController@index');
    // 設定用ユーザー情報更新
    Route::post('/user/setting', 'UserController@update');

    // 退会
    Route::post('/user/unsubscribe', 'UserController@destroy');

    //メール通知設定取得
    Route::get('/user/mail/notice', 'MailNoticeController@index');

    Route::post('/user/mail/notice', 'MailNoticeController@update');

    // メールアドレス設定
    Route::post('/user/mail/setting', 'MailSettingController@setting');

    // プロフィール情報取得
    Route::get('/profile/{id}', 'UserController@profileIndex');

    // ユーザーの投稿取得
    Route::post('/profile/post', 'PostController@profile_post');

    // TOP取得用
    Route::get('/top/post', 'PostController@topIndex');
    Route::get('/top/recruit', 'PostController@topRecruitIndex');
    Route::get('/top/comedy', 'ComedyController@topIndex');

    // タイムライン投稿取得
    Route::post('/post', 'PostController@index');

    // タイムライン投稿一覧取得
    Route::post('/post', 'PostController@index');
    // タイムライン投稿API
    Route::post('/post/new', 'PostController@create');

    // 投稿詳細
    Route::get('/post/{id}', 'PostController@post');
    // 投稿削除
    Route::delete('/post/{id}', 'PostController@destroy');
    // 投稿コメント
    Route::post('/post/reply', 'CommentController@reply');

    // コメント削除
    Route::delete('/comment/{id}', 'CommentController@destroy');
    
    // 相方募集一覧取得
    Route::post('/recruit', 'PostController@recruit_index');
    Route::post('/recruit/new', 'PostController@recruit_create');

    // 相方申請
    Route::post('/partner/new', 'PartnerController@create');
    // 相方申請　可否
    Route::post('/partner/application', 'PartnerController@application');
    // 相方申請菅理
    Route::post('/partner/{flg}', 'PartnerController@index');

    // 結成したコンビ一覧
    Route::get('/comedy', 'ComedyController@index');
    // 結成したコンビ
    Route::get('/comedy/{id}', 'ComedyController@comedy');
    // コンビ解散
    Route::delete('/comedy/{id}/delete', 'PartnerController@destroy');
    // コンビ名変更
    Route::post('/comedy/edit', 'ComedyController@edit');

    // いいね機能
    Route::put('/post/{id}/like', 'LikeController@like');
    // いいね解除
    Route::delete('/post/{id}/like', 'LikeController@unlike');

    // サイト内検索
    // 投稿一覧取得
    Route::post('/search/post', 'PostController@search_index');
    // ユーザー検索
    Route::post('/search/profile', 'UserController@searchIndex');
    // コンビ名検索
    Route::post('/search/comedy', 'ComedyController@search');

    // フォロー機能
    Route::put('/profile/{id}/follow', 'UserController@follow');
    // フォロー解除
    Route::delete('/profile/{id}/follow', 'UserController@unfollow');

    // フォロー取得
    Route::get('/profile/{id}/following', 'UserController@following');
    // フォロワー取得
    Route::get('/profile/{id}/followers', 'UserController@followers');

    // フォロー済かチェックする
    Route::post('/follow/check/{id}', 'FollowController@follow_check');

    // チャットルーム取得
    Route::get('/chat', 'RoomController@index');
    // チャットルーム作成
    Route::get('/chat/new/{id}', 'RoomController@create');
    // チャット相手の情報取得
    Route::get('/chat/info/{id}', 'RoomController@info');

    // チャットメッセージ取得
    Route::get('/chat/{id}', 'MessageController@index');

    // メッセージ作成
    Route::post('/chat/message/new', 'MessageController@create');

    // 通知取得
    Route::get('/notice', 'NoticeController@index');
    // 通知取得(既読済)
    Route::get('/notice/already', 'NoticeController@alreadyIndex');
    // 既読
    Route::post('/notice/{id}', 'NoticeController@update');

    // タグ検索
    Route::post('/tag/search', 'TagController@search');

    // 都道府県取得
    Route::get('/prefecture', 'PrefectureController@index');
    // 地域取得
    Route::get('/region', 'RegionController@index');
    // 世代取得
    Route::get('/generation', 'GenerationController@index');
    // 地域から都道府県を絞り込む
    Route::post('/prefecture/region/search', 'PrefectureController@region_search');

    // SNSログイン
    // Twitter
    Route::get('/socialite/twitter', 'SocialiteController@redirectToTwitterProvider');
});

// 会員登録トークン取得
Route::get('/verification/{token}', 'Auth\VerificationController@register')->name('verification');

// SNSログイン
// Twitterコールバック
Route::get('/twitter/callback', 'SocialiteController@handleTwitterProviderCallback');

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');

