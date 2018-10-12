<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.roles.index');
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
        $role = Role::updateOrCreate(
            [
                'name' => $request->name,
            ],
            [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]
        );

        if ($request->has('permissions')) {
            $role->attachPermissions($request->permissions);
        }

        return response()->json('Success!', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $roles = Role::all();

        return response()->json($roles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // $role = $role->with(['permissions' => function ($query) {
        //     $query->pluck('display_name', 'id');
        // }]);

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json('Role Updates', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json('Role Deleted', 200);
    }

    public function permissions()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.roles.permissions', compact('roles', 'permissions'));
    }

    public function sync_acl(Request $request)
    {
        //dd($request->all());
        $roles = Role::select('name', 'id')->get();

        foreach ($roles as $role) {
            $data = Role::where('name', $role->name)->first();
            $var = $role->name.'_permissions';
            $permissions = $request->$var;

            if ($permissions != null) {
                $data->syncPermissions($permissions);
            }
        }

        return redirect()->back();
    }
}
