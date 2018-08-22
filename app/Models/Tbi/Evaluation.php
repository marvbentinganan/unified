<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'set_id', 'employee_id', 'program_id', 'subject_id', 'semester_id', 'school_year_id'];

    protected $dates = ['deleted_at'];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Build\Program');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Build\Subject');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\Build\Semester');
    }

    public function school_year()
    {
        return $this->belongsTo('App\Models\Build\SchoolYear');
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
