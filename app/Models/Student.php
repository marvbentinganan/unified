<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number', 'date_of_birth'];

    protected $dates = ['deleted_at', 'date_of_birth'];
}
