<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public function createSocial($request){
        $this->user_id = Auth::user()->id;
        $this->twitter_id = $request->twitter;
        $this->instagram_id = $request->instagram;
        $this->line_id = $request->line;
        $this->save();
    }

    public function updateSocial($request){
        $this->twitter_id = $request->twitter;
        $this->instagram_id = $request->instagram;
        $this->line_id = $request->line;
        $this->update();
    }
}
