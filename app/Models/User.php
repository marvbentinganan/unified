<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'username', 'id_number', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function access_logs()
    {
        return $this->hasMany(Unifi\AccessLog::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Tbi\Evaluation::class);
    }

    public function preferences()
    {
        return $this->hasOne(Build\AccountSetting::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id_number', 'id_number');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'id_number', 'id_number');
    }
}
