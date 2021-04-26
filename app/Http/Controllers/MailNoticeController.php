<?php

namespace App\Http\Controllers;

use App\MailNotice;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MailNoticeController extends Controller
{
    public function index(){
        $mailNotice = MailNotice::where("user_id",  Auth::user()->id)->first();
        return $mailNotice;
    }

    public function update(Request $request){
        $mailNotice = MailNotice::where("user_id",  Auth::user()->id)->first();
        $user = User::find(Auth::user()->id);
        if(!empty($user->email)){
            if(!empty($mailNotice)){
                $mailNotice->updateMailNotice($request);
            }else{
                $mailNotice = new MailNotice();
                $mailNotice->createMailNotice($request);
            }
            return response($mailNotice, 200);
        }else{
            return response(404);
        }
    }
}
