<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function search(Request $request)
    {
        $tags = [];
        // タグ名検索
        if(!empty($request->name)){
            $tags = Tag::select('id', 'name')->where('name', 'like', "%$request->name%")->take(5)->get();
        // タグID検索
        }else if(!empty($request->id)){
            $tags = Tag::select('id', 'name')->where('id', '=', $request->id)->get();
        }
        return $tags;
    }
}
