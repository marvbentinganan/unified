<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;

class UserController extends Controller
{
    protected $permissions;
    protected $roles;

    public function __construct()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function index()
    {
        return view('users.dashboard');
    }

    public function active(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.directory.index');
    }

    public function list(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.directory.index');
    }

    public function updatePermission(Request $request, User $user)
    {
        $user->syncPermissions($request->permissions);

        return redirect()->back();
    }

    // API endpoint for Dropdown Options
    public function options()
    {
        $options = [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ];

        return response()->json($options);
    }
}
