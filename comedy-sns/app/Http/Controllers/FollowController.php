<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    // フォロー済かチェック
    public function follow_check(string $id){
        $follow = Follow::where('user_id', "=", Auth::user()->id)->where('follow_user_id', '=', $id)->count();
        return $follow;
    }
}
