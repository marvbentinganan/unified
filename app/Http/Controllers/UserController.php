<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Models\Student;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Build\Department;
use Excel;

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

    public function audit(Request $request)
    {
        $department = Department::find(1);
        $students = $department->students->pluck('id_number')->toArray();

        $temp = collect([]);
        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
            $path = $file->getRealPath();
            $data = Excel::load($path, function ($reader) {})->get();

            if ($data->count() != 0) {
                foreach ($data as $datum) {
                    $temp->push($datum->id_number);
                }
            }

            $filtered = array_diff($students, $temp->toArray());

            foreach ($filtered as $gone) {
                $student = Student::where('id_number', $gone)->first();
                $student->user->delete();
                $student->delete();
            }

            return redirect()->back()->with(['success_message' => 'Students Filtered']);
        }
    }
}
