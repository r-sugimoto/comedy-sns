<?php

namespace App\Http\Controllers;
use App\Comedy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComedyController extends Controller
{
    public function index(){
        $comedy = Comedy::with(['users'])
        ->whereHas('users', function($query){
            return $query->where('id', Auth::user()->id);
        })
        ->get();
        return $comedy;
    }

    // 投稿詳細
    public function comedy(string $id)
    {       
        $comedy = Comedy::where('id', $id)->with(['users'])->first();
        return $comedy;
    }

    // コンビ名変更
    public function edit(Request $request){
        $comedy = Comedy::where('id', $request->id)->first();
        $comedy->updateComedy($request);
        return $comedy;
    }

    // コンビ名検索
    public function search(Request $request){
        $comedy = Comedy::where('name', 'like', "%$request->freeword%")->with(['users'])
        ->orderBy(Comedy::UPDATED_AT, 'desc')->paginate(10);
        return $comedy;
    }

    public function topIndex(){
        $comedy = Comedy::with(['users'])
        ->orderBy(Comedy::UPDATED_AT, 'desc')->take(6)->get();
        return $comedy;
    }
}
