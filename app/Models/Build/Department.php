<?php

namespace App\Models\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function classes()
    {
        return $this->hasMany('App\Models\MyClass');
    }

    public function year_levels()
    {
        return $this->hasMany(YearLevel::class);
    }
}
