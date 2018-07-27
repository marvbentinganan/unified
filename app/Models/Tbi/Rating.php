<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'value', 'order', 'type_id'];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo('App\Models\Build\Type');
    }
}
