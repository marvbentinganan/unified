<?php

namespace App\Models\Digihub;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    protected $fillable = ['digihub_id'];

    public function digihub()
    {
        return $this->belongsTo(Digihub::class);
    }
}
