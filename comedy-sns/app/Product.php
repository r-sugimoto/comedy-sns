<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class Product extends Model
{
    protected $appends = [
        'product_url'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function getProductUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['name']);
    }

    // 投稿作成(画像ファイル)
    public function createPostPictures($post, $type, $file){
        $date = Carbon::now();
        $extension = $file->extension();
        $directory = "post/{$post->id}/";
        $this->type = $type;
        $name = Str::random(20) . '_' .$date->format('YmdHis') . '.' . $extension;
        $this->name = $directory . $name;
        Storage::cloud()
                ->putFileAs($directory, $file, $name, 'public');
        DB::beginTransaction();
        
        try {
            $post->products()->save($this);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // アップロードしたファイルを削除
            Storage::cloud()->delete($this->name);
            throw $exception;
        }
    }
    
    // 動画
    public function createPostMovie($post, $type, $file){
        $date = Carbon::now();
        $extension = $file->extension();
        if($extension === "qt"){
            $extension = "mp4";
        }
        $directory = "post/{$post->id}/";
        $this->type = $type;
        $name = Str::random(20) . '_' .$date->format('YmdHis') . '.' . $extension;
        $this->name = $directory . $name;
        Storage::cloud()
            ->putFileAs($directory, $file, $name, 'public');
        DB::beginTransaction();
        try {
            $post->products()->save($this);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // アップロードしたファイルを削除
            Storage::cloud()->delete($this->name);
            throw $exception;
        }
    }
    
    // youtube
    public function createPostYoutube($post, $type, $path){
        $this->type = $type;
        $this->name = $path;
        $post->products()->save($this);
    }
}
