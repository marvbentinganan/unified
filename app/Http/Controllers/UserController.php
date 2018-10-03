<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DataTables\UsersDataTable;
use Yajra\Datatables\Datatables;

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
        // $users = User::with(['roles'])->paginate(15);

        // return response()->json($users);
        // $users = User::all();

        // return Datatables::of($users)
        // ->editColumn('firstname', '{{ ucwords($firstname) }}')
        // ->editColumn('middlename', '{{ ucwords($lastname) }}')
        // ->addColumn('action', function ($users) {
        //     return '<a href="view/'.$users->id.'" class="ui fluid center aligned green label"><i class="ion-ios-person icon"></i>Manage</a>';
        // })
        // ->make(true);
        return $dataTable->render('users.directory.index');
    }
}
