<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
