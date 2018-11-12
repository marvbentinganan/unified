<?php

namespace App\Models\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'units', 'department_id', 'type_id'];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function classes()
    {
        return $this->hasMany('App\Models\MyClass');
    }
}
