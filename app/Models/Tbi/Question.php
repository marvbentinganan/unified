<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['ask', 'criteria_id'];

    protected $dates = ['deleted_at'];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function sets()
    {
        return $this->belongsToMany(Set::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
