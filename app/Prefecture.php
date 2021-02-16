<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    public function region(){
        return $this->belongsTo('App\Region');
    }
}
