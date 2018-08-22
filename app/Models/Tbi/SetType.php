<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function sets()
    {
        return $this->hasMany(Set::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
