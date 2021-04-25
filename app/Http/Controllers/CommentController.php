<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;
use App\Notice;
use App\User;
use App\MailNotice;
use App\Mail\CommentNoticeMail;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function reply(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->message = $request->message;
        $comment->save();

        // 通知用
        $post = Post::where('id', $comment->post_id)->first();

        // 通知先ユーザーと通知ユーザーが一緒ではない場合　通知を作成する
        if($post->user_id !== Auth::user()->id){
            $notice = new Notice();
            $request->to_user_id = $post->user_id;
            $request->comment_id = $comment->id;
            $notice->createCommentNotice($request);

            // メール通知用
            $toUser = User::find($post->user_id);
            // メールの設定があるか判定
            if(!empty($toUser->email)){
                $mailNotice = MailNotice::where("user_id",  $toUser->id)->first();
                if(!empty($mailNotice)){
                    if($mailNotice->mail_notice_flg === 1 && $mailNotice->comment_flg === 1){
                        $this->sendVerificationMail($toUser->email, Auth::user()->name);
                    }
                }
            }
        }

        return $comment;
    }

    public function destroy(string $commentId){
        $comment = Comment::where('id', $commentId)->where('user_id', Auth::user()->id)->first();
        if(!$comment){
            return false;
        }else{
            $comment->deleteComment();
        }

        return $comment;
    }

    // メール送信用
    private function sendVerificationMail($email, $name)
    {
        Mail::to($email)->send(new CommentNoticeMail($name));
    }
}
