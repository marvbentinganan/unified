<?php

namespace App\Models\Digihub;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Digihub extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'ip', 'location'];

    protected $dates = ['deleted_at'];

    protected $appends = ['thumb'];

    // protected $casts = [
    //     'ip' => 'ipAddress',
    // ];

    public function usages()
    {
        return $this->hasMany(Usage::class)->distinct('created_at');
    }

    public function monthlyUsage($month)
    {
        $usage = $this->usages()->whereRaw('extract(month from created_at) = ?', $month)->whereRaw('extract(year from created_at) = ?', Carbon::now()->year)->count();

        return $usage;
    }

    public function monthName($month)
    {
        $name = date('F', mktime(0, 0, 0, $month, 1));

        return $name;
    }

    public function getThumbAttribute()
    {
        // return '<img src="'.asset('images/digihub/'.$this->ip.'.jpg').'">';
        return asset('images/digihub/'.$this->ip.'.jpg');
        //<img src="http://localhost/unified/public/images/digihub/172.17.1.81.jpg">
    }
}
