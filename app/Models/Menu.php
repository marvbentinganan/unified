<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'order', 'icon', 'link', 'has_children', 'menu_id', 'is_primary'];

    protected $dates = ['deleted_at'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function children()
    {
        return $this->hasMany(Menu::class)->where('menu_id', $this->id)->orderBy('order');
    }

    public function dead_children()
    {
        return $this->hasMany(Menu::class)->where('menu_id', $this->id)->withTrashed();
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
