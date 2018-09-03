<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number', 'suffix', 'barcode', 'date_of_birth', 'department_id'];

    protected $dates = ['deleted_at', 'date_of_birth'];

    protected $appends = ['fullname'];

    public function department()
    {
        return $this->belongsTo('App\Models\Build\Department');
    }

    public function getFullnameAttribute()
    {
        return $this->firstname.' '.$this->lastname.' '.$this->suffix;
    }

    public function getDateOfBirthAttribute($value){
        return Carbon::parse($value)->toDateString();
    }
}
