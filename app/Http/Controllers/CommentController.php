<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller
{
    public function reply(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->message = $request->message;
        $comment->save();
        return $comment;
    }

    public function destroy(string $commentId){
        $comment = Comment::where('id', $commentId)->where('user_id', Auth::user()->id)->first();
        if(!$comment){
            return false;
        }else{
            $comment->uncomment();
        }

        return $comment;
    }
}
