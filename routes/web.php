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

