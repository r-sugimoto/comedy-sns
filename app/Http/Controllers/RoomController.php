<?php

namespace App\Http\Controllers;
use App\Room;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $room = Room::whereNull('name')->with(['users' => function($query){
            return $query->where('users.id', '<>', Auth::user()->id);
        }, 'messages'])
        ->whereHas('users', function($query){
            return $query->where('id', Auth::user()->id);
        })
        ->get();
        return $room;
    }

    public function info(string $id)
    {
        $room = Room::whereNull('name')->where('id', '=', $id)->with(['users' => function($query){
            return $query->where('users.id', '<>', Auth::user()->id);
        }])->whereHas('users', function($query){
            return $query->where('id', Auth::user()->id);
        })->first();
        return $room;
    }

    public function create(string $id){
        // チャットルームがあるかチェック
        $room = Room::whereNull('name')->with(['users'])
        ->whereHas('users', function($query){
            return $query->where('id', Auth::user()->id);
        })
        ->whereHas('users', function($query) use($id){
            return $query->where('id', $id);
        })
        ->first();
        
        if(!empty($room)){
            return $room;
        }else{
            $room = new Room();
            $room->save();
            $room->create_person($id);
        }
        return $room;
    }
}
