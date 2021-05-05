<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $table = 'mail_settings';

    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'email',
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
