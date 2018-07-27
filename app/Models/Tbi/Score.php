<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $fillable = ['record_id', 'question_id', 'criteria_id', 'points'];

    protected $dates = ['deleted_at'];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
