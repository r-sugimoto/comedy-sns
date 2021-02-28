<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function create_message($request)
    {
        $this->message = $request->message;
        $this->room_id = $request->room_id;
        $this->user_id = Auth::user()->id;
        if(!empty($request->partner_id)){
            $this->partner_id = $request->partner_id;
        }
        $this->save();
    }
    
    public function update_message($request)
    {
        $this->message = $request->message;
        $this->room_id = $request->room_id;
        $this->user_id = Auth::user()->id;
        if(!empty($request->partner_id)){
            $this->partner_id = $request->partner_id;
        }
        $this->update();
    }
}
