<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comedy extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function updateComedy($request){
        $this->name = $request->name;
        $this->update();
    }
    
    public function createComedy($partner){
        $this->name = "名無し";
        $this->save();
        $this->users()->attach($partner->user_id);
        $this->users()->attach($partner->partner_user_id);
    }
}
