<?php

namespace App\Models\Digihub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Digihub extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'ip', 'location'];

    protected $dates = ['deleted_at'];

    public function usages()
    {
        return $this->hasMany(Usage::class);
    }
}
