<?php

namespace App\Http\Controllers;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($postId)
    {
        \Auth::user()->like($postId);
        return "true";
    }

    public function unlike($postId)
    {
        \Auth::user()->unlike($postId);
        return "true";
    }
}
