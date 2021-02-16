<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function postComment(){
        
    }

    public function uncomment()
    {
        $this->delete();
        return true;
    }
}
