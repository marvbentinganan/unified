<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'value', 'order'];

    protected $dates = ['deleted_at'];

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }
}
