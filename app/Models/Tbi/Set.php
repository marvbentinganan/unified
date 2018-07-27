<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Set extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type_id'];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo('App\Models\Build\Type');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
