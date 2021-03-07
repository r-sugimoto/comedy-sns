<?php

namespace App\Http\Controllers;
use App\Message;
use App\Room;
use App\Partner;
use App\Comedy;
use App\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(String $flg){
        // 送った申請
        if($flg === "1"){
            $partner = Partner::where("user_id", Auth::user()->id)
            ->with(['user', 'partner_user', 'comedy'])
            ->orderBy(Partner::UPDATED_AT, 'desc')->get();
            return $partner;
        // 届いた申請
        } else if($flg === "2"){
            $partner = Partner::where("partner_user_id", Auth::user()->id)
            ->with(['user', 'partner_user', 'comedy'])
            ->orderBy(Partner::UPDATED_AT, 'desc')->get();

            return $partner;
        }
    }
    // 相方申請作成
    public function create(Request $request){
        $id = $request->user_id;
        
        // 申請テーブル登録・更新
        $partner = Partner::where("user_id", Auth::user()->id)
        ->where("partner_user_id", $id)
        ->first();

        if(!empty($partner)){
            // 申請更新
            $partner->update_partner($request);
        }else{
            // 新規
            $partner = new Partner();
            $partner->create_partner($request);
        }

        // 通知作成
        $request->partner_id = $partner->id;
        $request->to_user_id = $id;
        $notice = new Notice();
        $notice->createPartnerNotice($request);
        
        // 相方申請メッセージをチャットに送る
        $room = Room::whereNull('name')->with(['users'])
        ->whereHas('users', function($query){
            return $query->where('id', Auth::user()->id);
        })
        ->whereHas('users', function($query) use($id){
            return $query->where('id', $id);
        })
        ->first();
        
        if(empty($room)){
            $room = new Room();
            $room->save();
            $room->create_person($id);
        }
        $messages = Message::where('partner_id', $partner->id)->first();

        $request->room_id = $room->id;
        if(!empty($messages)){
            $messages->update_message($request);
        }else{         
            $messages = new Message();
            $messages->create_message($request);
        }
        return $messages;
    }

    public function application(Request $request){
        $partner = Partner::where("id", $request->partner_id)->first();

        if($request->application_flg === 0){
            $request->message = "申請拒否しました。";
        }else if($request->application_flg === 1){
            $request->message = "コンビ結成しました。";
        }

        // 相方申請ページ承認用
        $id = $request->user_id;
        if(!empty($id)){
            $room = Room::whereNull('name')->with(['users'])
                ->whereHas('users', function($query){
                    return $query->where('id', Auth::user()->id);
                })
                ->whereHas('users', function($query) use($id){
                return $query->where('id', $id);
                })
                ->first();
            $request->room_id = $room->id;
        }
        $messages = new Message();
        // 相方申請メッセージではない
        $request->partner_id = NULL;
        $messages->create_message($request);

        // 申請許可の場合
        if($request->application_flg === 1){
            $comedy = new Comedy();
            $comedy->create_comedy($partner);
            $request->comedy_id = $comedy->id;
        }
        $partner->update_application($request);

        // 通知作成
        $request->partner_id = $partner->id;
        $request->to_user_id = $partner->user_id;
        $notice = new Notice();
        $notice->createPartnerNotice($request);
        
        return $partner;
    }

    // コンビ解散
    public function destroy(string $id)
    {       
        $partner = Partner::where('comedy_id', $id)->first();
        $partner->deletePartner();
        return $partner;
    }
}
