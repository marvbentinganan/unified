<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number', 'barcode'];

    protected $dates = ['deleted_at'];

    public function designations()
    {
        return $this->belongsToMany(Build/Designation::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Build/Department::class);
    }
}
