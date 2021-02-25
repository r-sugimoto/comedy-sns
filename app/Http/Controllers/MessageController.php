<?php

namespace App\Http\Controllers;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(string $id)
    {
        $messages = Message::where("room_id", "=", $id)->with(['user', 'partner'])->get();
        return $messages;
    }

    public function create(Request $request)
    {
        $messages = new Message();
        $messages->create_message($request);
        return $messages;
    }
}
