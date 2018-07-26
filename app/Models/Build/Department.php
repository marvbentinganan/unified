<?php

namespace App\Models\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function faculties()
    {
        return $this->belongsToMany('App\Models\Faculty');
    }

    public function type()
    {
        return $this->belongsTo(Type::class)->where('model', 'department');
    }
}
