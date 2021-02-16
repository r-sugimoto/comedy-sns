<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function search(Request $request)
    {
        $tags = [];
        if(!empty($request->name)){
            $tags = Tag::select('id', 'name')->where('name', 'like', "%$request->name%")->take(10)->get();
        }else if(!empty($request->id)){
            $tags = Tag::select('id', 'name')->where('id', '=', $request->id)->take(10)->get();
        }
        return $tags;
    }
}
