<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserSettingRequest;
use App\Tag;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user()->with('tags')->first();
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
}
