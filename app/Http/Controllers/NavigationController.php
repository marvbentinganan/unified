<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Role;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::pluck('display_name', 'id');
        $parents = Menu::where('has_children', true)->pluck('name', 'id');
        $menus = Menu::orderBy('menu_id')->orderBy('order')->withTrashed()->get();

        return view('settings.navigation.index', compact('roles', 'parents', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('has_children')) {
            $has_children = true;
        } else {
            $has_children = false;
        }

        if ($request->has('is_primary')) {
            $is_primary = true;
        } else {
            $is_primary = false;
        }

        $menu = Menu::create([
            'name' => ucwords($request->name),
            'link' => $request->link,
            'icon' => $request->icon,
            'order' => $request->order,
            'menu_id' => $request->menu_id,
            'has_children' => $has_children,
            'is_primary' => $is_primary,
        ]);

        $menu->roles()->attach($request->roles);

        return response()->json('Menu Added', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $roles = Role::pluck('display_name', 'id');
        $parents = Menu::where('has_children', true)->pluck('name', 'id');

        return view('settings.navigation.edit', compact('roles', 'parents', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if ($request->has('has_children')) {
            $has_children = true;
        } else {
            $has_children = false;
        }

        if ($request->has('is_primary')) {
            $is_primary = true;
        } else {
            $is_primary = false;
        }

        $menu->update([
            'name' => $request->name,
            'link' => $request->link,
            'icon' => $request->icon,
            'order' => $request->order,
            'menu_id' => $request->menu_id,
            'has_children' => $has_children,
            'is_primary' => $is_primary,
        ]);

        $menu->roles()->sync($request->roles);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if ($menu->has('children')) {
            foreach ($menu->children as $child) {
                $child->delete();
            }
        }
        $menu->delete();

        return response()->json('Menu Deleted', 200);
    }

    public function restore($menu)
    {
        $item = Menu::withTrashed()->where('id', $menu)->first();
        $item->restore();

        if ($item->has('dead_children')) {
            foreach ($item->dead_children as $dead) {
                $dead->restore();
            }
        }

        return response()->json('Menu Restored', 200);
    }
}
