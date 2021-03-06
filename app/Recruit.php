<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruit extends Model
{
    public function prefecture(){
        return $this->belongsTo('App\Prefecture');
    }
    public function generation(){
        return $this->belongsTo('App\Generation');
    }
    public function createRecruit($request){
        if($request->prefecture === 'null' || $request->prefecture === '0'){
            $this->prefecture_id = NULL;
        }else{
            $this->prefecture_id = $request->prefecture;
        }
        if($request->generation === 'null' || $request->generation === '0'){
            $this->generation_id = NULL;
        }else{
            $this->generation_id = $request->generation;
        }
        $this->save();
    }
}