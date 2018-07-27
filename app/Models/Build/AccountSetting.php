<?php

namespace App\Models\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountSetting extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'semester_id', 'school_year_id'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
