<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserSettingRequest;
use App\Tag;

class UserController extends Controller
{
    // プロフィール設定ページ
    public function index(){
        $user = User::select('id', 'name', 'age', 'published_age_flg', 'prefecture_id', 'published_prefecture_flg', 'introduction', 'thumbnail')
        ->where('id', Auth::user()->id)->with(['tags'])->first();
        return $user;
    }

    // ユーザー情報更新
    public function update(UpdateUserSettingRequest $request){
        $user = Auth::user();
        $user->updateUser($request);
        $request->tags->each(function ($tagName) use ($user) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $user->tags()->attach($tag);
        });
        return response($user, 201);
    }

    // プロフィールページ情報取得
    public function profile_index(string $id){
        $user = User::where('id', $id)->with(['tags', 'prefecture'])->first();
        return $user;
    }

    // プロフィールページ情報取得
    public function search_index(Request $request){
        $freeword = $request->freeword;
        $tag = $request->tag;
        $user = User::with(['tags'])
        ->when($tag, function ($query, $tag){
            return $query->whereHas('tags', function($query) use($tag) {
                return $query->where('id', $tag);
            });
        })
        ->where('name', 'like', "%$freeword%")
        ->orWhere('introduction', 'like', "%$freeword%")
        ->orderBy(User::CREATED_AT, 'desc')->paginate(10);
        return $user;
    }

    public function destroy(Request $request){
        $user = User::find(Auth::user()->id);
        $user->delete();
        return $user;
    }

    public function follow($userId)
    {
        Auth::user()->follow($userId);
        return "true";
    }

    public function unfollow($userId)
    {
        Auth::user()->unfollow($userId);
        return "true";
    }

    public function following($userId)
    {
        $user = User::where('id', $userId)->with('follow_users')->first();
        return $user;
    }

    public function followers($userId)
    {
        $user = User::where('id', $userId)->with('follower_users')->first();
        return $user;
    }

    // チャットルーム情報取得
    public function chat_index()
    {
        $user = Auth::user()->with(['rooms.users'])->get();
        return $user;
    }
}
