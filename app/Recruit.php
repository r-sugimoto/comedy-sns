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
        if($request->prefecture_id === 'null' || $request->prefecture_id === '0'){
            $this->prefecture_id = NULL;
        }else{
            $this->prefecture_id = $request->prefecture_id;
        }
        if($request->generation_id === 'null' || $request->generation_id === '0'){
            $this->generation_id = NULL;
        }else{
            $this->generation_id = $request->generation_id;
        }
        $this->save();
    }
}