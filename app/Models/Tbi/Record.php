<?php

namespace App\Models\Tbi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'evaluation_id', 'pros', 'cons', 'remarks', 'topic'];

    protected $dates = ['deleted_at'];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
