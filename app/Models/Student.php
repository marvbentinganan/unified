<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number', 'suffix', 'barcode', 'date_of_birth', 'department_id', 'default_password'];

    protected $dates = ['deleted_at', 'date_of_birth'];

    protected $appends = ['fullname'];

    protected $hidden = ['default_password'];

    public function department()
    {
        return $this->belongsTo('App\Models\Build\Department');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_number', 'id_number');
    }

    public function getFullnameAttribute()
    {
        return $this->firstname.' '.$this->lastname.' '.$this->suffix;
    }

    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->toDateString();
    }

    //Helper Functions
    public function generatePassword()
    {
        $data = str_replace('-', '', $this->date_of_birth);
        $password = bcrypt($data);

        return $password;
    }

    public function classes()
    {
        return $this->belongsToMany(MyClass::class);
    }
}
