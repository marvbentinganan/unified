<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number', 'barcode', 'suffix', 'title', 'is_faculty', 'is_manager'];

    protected $dates = ['deleted_at'];

    protected $appends = ['fullname'];

    protected $with = ['user'];

    public function designations()
    {
        return $this->belongsToMany(Build\Designation::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Build\Program::class);
    }

    public function classes()
    {
        return $this->hasMany(MyClass::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Tbi\Evaluation::class);
    }

    public function getFullnameAttribute()
    {
        return $this->firstname.' '.$this->lastname.' '.$this->suffix;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_number', 'id_number');
    }

    //Helper Functions
    public function generateUsername()
    {
        $first = substr($this->firstname, 0, 1);
        $last = str_replace(' ', '', $this->lastname);
        $username = strtolower($first.$last);

        return $username;
    }

    public function generatePassword()
    {
        $first = substr($this->firstname, 0, 1);
        $last = substr($this->lastname, 0, 1);
        $temp = strtolower($first.$last.'@'.$this->id_number);
        $password = bcrypt($temp);

        return $password;
    }

    public function getSuffix($value)
    {
        if (ends_with($value, 'Jr.')):
            return ', Jr.'; elseif (ends_with($value, ' Iii')):
            return ', III'; elseif (ends_with($value, ' Ii')):
            return ', II'; elseif (ends_with($value, ' Iv')):
            return ', IV'; else:
            return null;
        endif;
    }

    public function sanitizeFirstname($value)
    {
        if (ends_with($value, ' Jr.')):
            return ucwords(rtrim($value, 'Jr.')); elseif (ends_with($value, ' Iii')):
            return ucwords(rtrim($value, 'Iii')); elseif (ends_with($value, ' Ii')):
            return ucwords(rtrim($value, 'Ii')); elseif (ends_with($value, ' Iv')):
            return ucwords(rtrim($value, 'Iv')); else:
            return ucwords($value);
        endif;
    }

    public function isFacultyCheck()
    {
        if ($this->is_faculty == true) {
            return true;
        }

        return false;
    }

    public function isManagerCheck()
    {
        if ($this->is_manager == true) {
            return true;
        }

        return false;
    }
}
