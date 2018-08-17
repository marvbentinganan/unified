<?php

namespace App\Models\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'model'];

    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function sets()
    {
        return $this->hasMany('App\Models\Tbi\Set');
    }
}