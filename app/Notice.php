<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notice extends Model
{
    public function comments()
    {
        return $this->belongsToMany('App\Comment');
    }
    public function messages()
    {
        return $this->belongsToMany('App\Message');
    }
    public function partners()
    {
        return $this->belongsToMany('App\Partner');
    }

    public function updateNotice(){
        $this->check_flg = 1;
        $this->update();
    }

    public function createCommentNotice($request){
        $this->from_user_id = Auth::user()->id;
        $this->to_user_id = $request->to_user_id;
        // 1:コメント
        $this->action_type = 1;
        $this->save();
        $this->comments()->attach($request->comment_id);
    }

    public function createMessageNotice($request){
        $this->from_user_id = Auth::user()->id;
        $this->to_user_id = $request->to_user_id;
        // 2:DM
        $this->action_type = 2;
        $this->save();
        $this->messages()->attach($request->message_id);
    }

    public function createPartnerNotice($request){
        $this->from_user_id = Auth::user()->id;
        $this->to_user_id = $request->to_user_id;
        // 3:相方申請
        $this->action_type = 3;
        $this->save();
        $this->partners()->attach($request->partner_id);
    }
}
