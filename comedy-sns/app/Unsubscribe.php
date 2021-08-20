<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Unsubscribe extends Model
{
    public function createUnsubscribe($request)
    {
        $this->user_id = Auth::user()->id;
        $this->reason = $request->reason;
        $this->save();
    }
}
