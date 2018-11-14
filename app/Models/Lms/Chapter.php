<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'lesson_id', 'title', 'content', 'slug', 'active', 'for_approval', 'approved_by'];

    protected $dates = ['deleted_at'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
