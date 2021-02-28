<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comedy extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function comedyDelete(){
        $this->unuser();
        $this->uncomedy();
        return true;
    }

    public function comedyEdit($request){
        $this->name = $request->name;
        $this->update();
    }

    public function uncomedy(){
        $this->delete();
        return true;
    }

    // ユーザーの紐付け解除
    public function unuser(){
        $this->users()->detach();
        return true;
    }
    

    public function create_comedy($partner){
        $this->name = "名無し";
        $this->save();
        $this->users()->attach($partner->user_id);
        $this->users()->attach($partner->partner_user_id);
    }
}
