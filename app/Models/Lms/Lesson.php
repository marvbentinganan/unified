<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'objective',
        'slug',
        'code',
        'approved',
        'department_id',
        'subject_id',
        'program_id',
        'approved_by',
    ];

    protected $dates = ['deleted_at'];

    protected $with = ['chapters', 'department', 'subject', 'program'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('created_at');
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

    public function approval()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function scopeForManagers($query)
    {
        if (auth()->user()->hasRole('management')) {
            $employee = auth()->user()->employee;
            $programs = $employee->programs;

            return $query->whereIn('program_id', $programs->pluck('id'))->with(['department', 'program', 'subject'])->withTrashed();
        }
    }
}
