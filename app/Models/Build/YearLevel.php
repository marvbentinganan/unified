<?php

namespace App\Models\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YearLevel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'department_id'];

    protected $dates = ['deleted_at'];

    public function classes()
    {
        return $this->hasMany('App\Models\MyClass');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
