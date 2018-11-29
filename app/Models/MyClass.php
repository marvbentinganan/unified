<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyClass extends Model
{
    use softDeletes;

    protected $fillable = [
        'name',
        'code',
        'section',
        'employee_id',
        'department_id',
        'program_id',
        'subject_id',
        'year_level_id',
        'semester_id',
        'school_year_id',
    ];

    protected $dates = ['deleted_at'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Build\Department::class);
    }

    public function program()
    {
        return $this->belongsTo(Build\Program::class);
    }

    public function subject()
    {
        return $this->belongsTo(Build\Subject::class);
    }

    public function year_level()
    {
        return $this->belongsTo(Build\YearLevel::class);
    }

    public function semester()
    {
        return $this->belongsTo(Build\Semester::class);
    }

    public function school_year()
    {
        return $this->belongsTo(Build\SchoolYear::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->orderBy('lastname');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lms\Lesson::class);
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
