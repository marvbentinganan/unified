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
}
