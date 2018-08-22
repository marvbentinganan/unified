<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'value', 'order', 'set_type_id'];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo(SetType::class);
    }
}
