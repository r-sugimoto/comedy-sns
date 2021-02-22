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
    // 認証API
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('user', fn () => Auth::user())->name('user');

    // 設定用ユーザー情報取得
    Route::get('/user/setting', 'UserController@index');
    // 設定用ユーザー情報更新
    Route::post('/user/setting', 'UserController@update');

    // プロフィール情報取得
    Route::get('/profile/{id}', 'UserController@profile_index');

    // ユーザーの投稿取得
    Route::post('/profile/post', 'PostController@profile_post');

    // 投稿一覧取得
    Route::post('/post', 'PostController@index');
    // 投稿API
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

    // いいね機能
    Route::put('/post/{id}/like', 'LikeController@like');
    // いいね解除
    Route::delete('/post/{id}/like', 'LikeController@unlike');

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
});

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');

