<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    // 1対1のチャット作成
    public function create_person($id){
        $this->users()->attach(Auth::user()->id);
        $this->users()->attach($id);
    }
}
