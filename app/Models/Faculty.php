<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use SoftDeletes;

    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number'];

    protected $dates = ['deleted_at'];

    public function departments()
    {
        return $this->belongsToMany(Build/Department::class);
    }
}
