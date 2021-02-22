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

    public function create($request)
    {
        $this->message = $request->message;
        $this->room_id = $request->room_id;
        $this->user_id = Auth::user()->id;
        $this->save();
    }
}
