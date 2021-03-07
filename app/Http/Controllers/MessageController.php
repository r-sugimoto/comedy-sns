<?php

namespace App\Http\Controllers;
use App\Message;
use App\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(string $id)
    {
        $messages = Message::where("room_id", "=", $id)
        ->with(['user', 'partner', 'notices'])->
        orderBy(Message::UPDATED_AT, 'asc')->get();
        return $messages;
    }

    public function create(Request $request)
    {
        $message = new Message();
        $message->create_message($request);

        if($request->to_user_id !== Auth::user()->id){
            $notice = new Notice();
            $request->message_id = $message->id;
            $notice->createMessageNotice($request);
        }
        return $message;
    }

    public function notice_index(string $id)
    {
        $messages = Message::where("room_id", "=", $id)->with(['user', 'partner', 'notices'])
        ->whereHas('notices', function($query) {
            return $query->where('check_flg', 0)->where('to_user_id', Auth::user()->id);
        })->get();
        foreach($messages as $message){
            $id = $message->id;
            $notice = Notice::with(['messages'])->whereHas('messages', function($query) use($id){
                return $query->where('id', $id);
            })->first();
            if(!empty($notice)){
                $notice->updateNotice();
            }
        }
        return response(200);
    }
}
