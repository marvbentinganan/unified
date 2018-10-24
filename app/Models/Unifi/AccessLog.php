<?php

namespace App\Models\Unifi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'device', 'ip', 'expires_on', 'url'];

    protected $dates = ['deleted_at', 'expires_on'];

    protected $appends = ['expires_in'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function time_remaining()
    {
        $remaining = now()->diffInRealMinutes($this->expires_on);
        if ($this->expires_on < now()) {
            $remaining = 0;
        }

        return $remaining.' minutes';
    }

    public function getExpiresInAttribute()
    {
        $remaining = now()->diffInRealMinutes($this->expires_on);
        if ($this->expires_on < now()) {
            $remaining = 0;
        }

        return $remaining.' minutes';
    }
}
