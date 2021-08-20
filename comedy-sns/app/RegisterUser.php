<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterUser extends Model
{
    protected $table = 'register_users';

    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'email',
        'name',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
