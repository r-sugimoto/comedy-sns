<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MailNotice extends Model
{
    public function createMailNotice($request){
        $this->user_id = Auth::user()->id;
        if($request->mail_notice){
            $this->mail_notice_flg = 1;
        }else{
            $this->mail_notice_flg = 0;
        }

        if($request->comment){
            $this->comment_flg = 1;
        }else{
            $this->comment_flg = 0;
        }

        if($request->message){
            $this->message_flg = 1;
        }else{
            $this->message_flg = 0;
        }

        if($request->partner){
            $this->partner_flg = 1;
        }else{
            $this->partner_flg = 0;
        }

        $this->save();
    }

    public function updateMailNotice($request){
        if($request->mail_notice){
            $this->mail_notice_flg = 1;
        }else{
            $this->mail_notice_flg = 0;
        }

        if($request->comment){
            $this->comment_flg = 1;
        }else{
            $this->comment_flg = 0;
        }

        if($request->message){
            $this->message_flg = 1;
        }else{
            $this->message_flg = 0;
        }

        if($request->partner){
            $this->partner_flg = 1;
        }else{
            $this->partner_flg = 0;
        }

        $this->update();
    }
}