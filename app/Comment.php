<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function notices()
    {
        return $this->belongsToMany('App\Notice');
    }

    public function deleteComment(){
        $this->uncomment();
        $this->unnotice();
    }

    public function uncomment()
    {
        $this->delete();
        return true;
    }

    public function unnotice()
    {
        $this->notices()->delete();
        $this->notices()->detach();
        return true;
    }
}
