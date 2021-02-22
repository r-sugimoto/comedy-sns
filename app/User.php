<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'thumbnail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'thumbnail_url', 'follow_count', 'follower_count'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Post', 'likes')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function prefecture(){
        return $this->belongsTo('App\Prefecture');
    }

    // フォローユーザー
    public function follow_users()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_user_id')->withTimestamps();
    }

    // フォロワーユーザー
    public function follower_users()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_user_id', 'user_id')->withTimestamps();
    }

    // チャットルーム取得
    public function rooms()
    {
        return $this->belongsToMany('App\Room');
    }

    public function updateUser($request)
    {
        $this->name = $request->name;
        if($request->introduction !== 'null'){
            $this->introduction = $request->introduction;
        }
        if($request->age === 'null' || $request->age === '0'){
            $this->age = NULL;
        }else{
            $this->age = $request->age;
        }
        if($request->prefecture_id === 'null' || $request->prefecture_id === '0'){
            $this->prefecture_id = NULL;
        }else{
            $this->prefecture_id = $request->prefecture_id;
        }
        $this->published_age_flg = (int)$request->published_age;
        $this->published_prefecture_flg = (int)$request->published_prefecture;
        if(!empty($request->thumbnail)){
            $this->updateUserThumbnail($request->thumbnail);
        }
        $this->save();
        $this->untag();
    }

    // タグの紐付け解除
    public function untag(){
        $this->tags()->detach();
        return true;
    }

    // いいね機能
    public function like($postId)
    {
        $exist = $this->is_like($postId);

        if($exist){
            return false;
        }else{
            $this->likes()->attach($postId);
            return true;
        }
    }
    public function unlike($postId)
    {     
        $exist = $this->is_like($postId);

        if($exist){
            $this->likes()->detach($postId);
            return true;
        }else{
            return false;
        }
    }
    // いいね存在チェック
    public function is_like($postId)
    {
        return $this->likes()->where('post_id',$postId)->first();
    }

    // フォロー機能
    public function follow($userId)
    {
        $exist = $this->is_follow($userId);

        if($exist){
            return false;
        }else{
            $this->follow_users()->attach($userId);
            return true;
        }
    }
    public function unfollow($userId)
    {     
        $exist = $this->is_follow($userId);

        if($exist){
            $this->follow_users()->detach($userId);
            return true;
        }else{
            return false;
        }
    }
    // フォロー済かチェック
    public function is_follow($userId)
    {
        return $this->follow_users()->where('follow_user_id',$userId)->first();
    }

    // プロフィール画像をAWSにアップ
    public function updateUserThumbnail($file){
        $date = Carbon::now();
        $extension = $file->extension();
        $directory = "profile/thumbnail/{$this->id}/";
        $name = Str::random(20) . '_' .$date->format('YmdHis') . '.' . $extension;
        $this->thumbnail = $directory . $name;
        Storage::cloud()
            ->putFileAs($directory, $file, $name, 'public');
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // アップロードしたファイルを削除
            Storage::cloud()->delete($this->thumbnail);
            throw $exception;
        }
    }
    // フォロー数取得
    public function getFollowCountAttribute()
    {
        return $this->follow_users()->count();
    }
    // フォロワー数取得
    public function getFollowerCountAttribute()
    {
        return $this->follower_users()->count();
    }
    // 画像URL取得
    public function getThumbnailUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['thumbnail']);
    }

}
