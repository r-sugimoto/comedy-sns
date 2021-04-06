<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $appends = [
      'likes_count', 'liked_by_user', 'comments_count'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
    public function comments()
    {
        return $this->belongsToMany('App\User', 'comments')->withPivot(['id','created_at', 'message'])->orderBy('pivot_created_at', 'desc');
    }
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
    public function recruit()
    {
        return $this->belongsTo('App\Recruit');
    }

    // 投稿追加
    public function createPost($request)
    {
        $this->user_id = Auth::user()->id;
        $this->title = $request->title;
        $this->message = $request->message;
        if($request->recruit_id !== null){
            $this->recruit_id = $request->recruit_id;
        }
        $this->save();
        $this->untag();
    }

    // 削除機能
    public function deletePost($postId){
        $this->untag();
        $this->unproduct($postId);
        $this->unlike();
        $this->unrecruit();
        $this->unpost();
        return true;
    }

    // 投稿削除
    public function unpost(){
        $this->delete();
        return true;
    }
    // タグの紐付け解除
    public function untag(){
        $this->tags()->detach();
        return true;
    }
    // プロダクト削除
    public function unproduct($postId){
        $this->products()->delete();
        $this->products()->detach();
        $directory = 'post/' . $postId . '/';
        Storage::cloud()->deleteDirectory($directory);
        return true;
    }
    // いいね 削除
    public function unlike(){
        $this->likes()->detach();
        return true;
    }
    // 相方募集削除
    public function unrecruit(){
        $this->recruit()->delete();
        return true;
    }
    // いいねカウント
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
    // いいね済
    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return (bool)$this->likes->where('id', Auth::user()->id)->count();
    }
    // コメント数取得
    public function getCommentsCountAttribute()
    {
        return $this->comments->count();
    }
}
