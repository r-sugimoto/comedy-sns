<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Comment;
use App\Tag;
use App\Partner;
use App\Room;
use App\Follow;
use App\Like;
use App\Notice;
use App\Unsubscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserSettingRequest;

class UserController extends Controller
{
    // ユーザー情報設定ページ
    public function index(){
        $user = User::select('id', 'name', 'age', 'published_age_flg', 'prefecture_id', 'published_prefecture_flg', 'introduction', 'thumbnail')
        ->where('id', Auth::user()->id)->with(['tags:id,name'])->first();
        return $user;
    }

    // ユーザー情報更新
    public function update(UpdateUserSettingRequest $request){
        $user = Auth::user();
        $user->updateUser($request);
        $user->untag();
        $request->tags->each(function ($tagName) use ($user) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $user->tags()->attach($tag);
        });
        return $user;
    }

    // プロフィールページ情報取得
    public function profileIndex(string $id){
        $user = User::where('id', $id)->with(['tags:id,name', 'prefecture:id,name'])->first();
        return $user;
    }

    // プロフィールページ情報取得
    public function searchIndex(Request $request){
        $freeword = $request->freeword;
        $tag = $request->tag;
        $user = User::with(['tags'])
        ->when($tag, function ($query, $tag){
            return $query->whereHas('tags', function($query) use($tag) {
                return $query->where('id', $tag);
            });
        })
        ->where('name', 'like', "%$freeword%")
        ->orWhere('introduction', 'like', "%$freeword%")
        ->orderBy(User::CREATED_AT, 'desc')->paginate(10);
        return $user;
    }

    public function destroy(Request $request){
        // 退会処理(user情報:論理削除 それ以外:物理削除)
        $posts = Post::where("user_id", Auth::user()->id)->get();
        // 投稿関連削除
        if(!empty($posts)){
            foreach($posts as $post){
                $post->deletePost($post->id);
            }
        }
        //コメント削除
        $comments = Comment::where("user_id", Auth::user()->id)->get();
        if(!empty($comments)){
            foreach($comments as $comment){
                $comment->deleteComment();
            }
        }
        // フォロー情報削除
        $follows = Follow::where("user_id", Auth::user()->id)
        ->orWhere('follow_user_id', Auth::user()->id)->get();
        if(!empty($follows)){
            foreach($follows as $follow){
                $follow->delete();
            }
        }
        // いいね削除
        $likes = Like::where("user_id", Auth::user()->id)->get();
        if(!empty($likes)){
            foreach($likes as $like){
                $like->delete();
            }
        }
        // 相方申請、コンビ削除
        $partners = Partner::where("user_id", Auth::user()->id)
        ->orWhere('partner_user_id', Auth::user()->id)->get();
        if(!empty($partners)){
            foreach($partners as $partner){
                $partner->deletePartner();
            }
        }
        // DM削除
        $userId = Auth::user()->id;
        $rooms = Room::with(['users'])->whereHas('users', function($query) use($userId){
            return $query->where('users.id', $userId);
        })->get();
        if (!empty($rooms)) {
            foreach ($rooms as $room) {
                $room->deleteRoom();
            }
        }
        // 通知削除
        $notices = Notice::where('from_user_id', Auth::user()->id)
        ->orWhere('to_user_id', Auth::user()->id)->get();
        if(!empty($notices)){
            foreach($notices as $notice) {
                $notice->deleteNotice();
            }
        }

        if(!empty($request->reason)){
            $unsubscribe = new Unsubscribe();
            $unsubscribe->createUnsubscribe($request);
        }

        $user = User::find(Auth::user()->id);
        $user->delete();
        return $user;
    }

    public function follow($userId)
    {
        Auth::user()->follow($userId);
        return response(200);
    }

    public function unfollow($userId)
    {
        Auth::user()->unfollow($userId);
        return response(200);
    }

    public function following($userId)
    {
        $user = User::with(['follow_users'])->find($userId);
        return $user;
    }

    public function followers($userId)
    {
        $user = User::with(['follower_users'])->find($userId);
        return $user;
    }
}
