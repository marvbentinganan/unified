<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'title', 'description', 'objective', 'slug', 'active', 'for_approval', 'department_id', 'subject_id', 'program_id', 'approved_by'];

    protected $dates = ['deleted_at'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function classes()
    {
        return $this->belongsToMany('App\Models\MyClass');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Build\Department');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Build\Program');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Build\Subject');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function approved()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
