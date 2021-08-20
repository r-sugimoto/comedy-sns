<?php

namespace App\Http\Controllers;
use App\Message;
use App\Notice;
use App\Room;
use App\User;
use App\MailNotice;
use App\Mail\MessageNoticeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(int $id)
    {
        // チャットルームチェック
        $room = Room::where("id", $id)->with('users')
        ->whereHas('users', function($query){
            return $query->where('id', Auth::user()->id);
        })->first();

        if(!empty($room)){
            // 通知を既読にする
            $notice_message = Notice::where('to_user_id', Auth::user()->id)
            ->where("action_type", 2)->where('check_flg', 0)->with('messages')
            ->whereHas('messages', function($query) use($id){
                return $query->where('room_id', $id);
            })->get();

            if(!empty($notice_message)){
                foreach($notice_message as $notice){
                    $notice->updateNotice();
                }
            }

            $messages = Message::where('room_id', $id)
            ->with(['user', 'partner'])->
            orderBy('messages.updated_at', 'asc')->get();
            return $messages;
            
        }else{
            return response($room, 404);
        }
    }

    public function create(Request $request)
    {
        $message = new Message();
        $message->create_message($request);

        if($request->to_user_id !== Auth::user()->id){
            $notice = new Notice();
            $request->message_id = $message->id;
            $notice->createMessageNotice($request);

            // メール通知用
            $toUser = User::find($request->to_user_id);
            // メールの設定があるか判定
            if(!empty($toUser->email)){
                $mailNotice = MailNotice::where("user_id",  $toUser->id)->first();
                if(!empty($mailNotice)){
                    if($mailNotice->mail_notice_flg === 1 && $mailNotice->message_flg === 1){
                        $this->sendVerificationMail($toUser->email, Auth::user()->name);
                    }
                }
            }
        }
        return $message;
    }

    // メール送信用
    private function sendVerificationMail($email, $name)
    {
        Mail::to($email)->send(new MessageNoticeMail($name));
    }
}
