<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notice;

class NoticeController extends Controller
{
    public function index(){
        $notice = Notice::where('to_user_id', Auth::user()->id)
        ->where('check_flg', 0)->with(['comments.user', 'messages.user', 'partners.user'])
        ->orderBy(Notice::CREATED_AT, 'desc')->get();
        return $notice;
    }

    public function alreadyIndex(){
        $notice = Notice::where('to_user_id', Auth::user()->id)
        ->where('check_flg', 1)->with(['comments.user', 'messages.user', 'partners.user' => function($query){
            return $query->where('id', '<>', Auth::user()->id);
        }])
        ->orderBy(Notice::CREATED_AT, 'desc')->take(10)->get();
        return $notice;
    }

    public function update(String $id){
        $notice = Notice::where('id', $id)->first();
        $notice->updateNotice();
        return $notice;
    }
}

