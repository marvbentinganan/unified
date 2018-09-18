<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['firstname', 'middlename', 'lastname', 'id_number', 'barcode', 'suffix', 'title'];

    protected $dates = ['deleted_at'];

    protected $appends = ['fullname'];

    public function designations()
    {
        return $this->belongsToMany(Build / Designation::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Build / Department::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Tbi / Evaluation::class);
    }

    public function getFullnameAttribute()
    {
        return $this->firstname.' '.$this->lastname.' '.$this->suffix;
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
}
