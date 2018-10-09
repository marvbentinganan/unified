<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;

class UserController extends Controller
{
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
}
