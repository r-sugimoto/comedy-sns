<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function partner_user()
    {
        return $this->belongsTo('App\User', 'partner_user_id');
    }

    public function comedy()
    {
        return $this->belongsTo('App\Comedy');
    }

    public function notices()
    {
        return $this->belongsToMany('App\Notice');
    }

    protected $fillable = ['user_id', 'partner_user_id', 'message', 'application_flg'];

    public function create_partner($request){
        $this->user_id = Auth::user()->id;
        $this->partner_user_id = $request->user_id;
        $this->message = $request->message;
        $this->application_flg = NULL;
        $this->save();
    }
    public function update_partner($request){
        $this->user_id = Auth::user()->id;
        $this->partner_user_id = $request->user_id;
        $this->message = $request->message;
        $this->application_flg = NULL;
        $this->update();
    }
    public function update_application($request){
        $this->application_flg = $request->application_flg;
        if(!empty($request->comedy_id)){
            $this->comedy_id = $request->comedy_id;
        }
        $this->update();
    }

    public function deletePartner(){
        $this->uncomedy();
        $this->unnotice();
        $this->unpartner();
    }

    public function unpartner()
    {
        $this->delete();
    }


    public function uncomedy()
    {
        $this->comedy()->delete();
    }

    public function unnotice()
    {
        $this->notices()->delete();
        $this->notices()->detach();
    }

    
}
