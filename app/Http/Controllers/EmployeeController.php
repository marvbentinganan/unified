<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use App\Models\Build\Program;
use Excel;

class EmployeeController extends Controller
{
    protected $directory;
    protected $permissions;
    protected $roles;

    public function __construct()
    {
        $this->directory = 'users.employees';
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.employees.index');
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
        $employee = Employee::updateOrCreate(
            [
                'id_number' => $request->id_number,
            ],
            [
                'id_number' => $request->id_number,
                'firstname' => ucwords($request->firstname),
                'middlename' => ucwords($request->middlename),
                'lastname' => ucwords($request->lastname),
                'suffix' => $request->suffix,
                'title' => $request->title,
                'is_faculty' => $request->is_faculty,
                'is_manager' => $request->is_manager,
            ]
        );

        if ($request->has('programs')) {
            $employee->programs()->sync($request->programs);
        }

        $user = $this->createUser($employee);
        $user->syncRoles($request->roles);
    }

    public function get()
    {
        $employees = Employee::orderby('lastname')
        ->get();

        return response()->json($employees);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $roles = $this->roles->pluck('display_name', 'id');
        $access = $employee->user->allPermissions()->pluck('id');
        if ($access != null) {
            $permissions = Permission::whereNotIn('id', $access)->get();
        } else {
            $permissions = $this->permissions;
        }

        return view($this->directory.'.show', compact('employee', 'roles', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        try {
            $id_number = $employee->id_number;

            $employee->update([
                'id_number' => $request->id_number,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffix' => $request->suffix,
                'title' => $request->title,
                'is_faculty' => $request->is_faculty,
                'is_manager' => $request->is_manager,
            ]);

            if ($request->has('programs')) {
                $employee->programs()->sync($request->programs);
            }

            $user = $this->updateUser($employee->id, $id_number);

            $user->syncRoles($request->roles);

            return response()->json('User Updated', 200);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function upload(Request $request)
    {
        ini_set('max_execution_time', 900);

        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
            $path = $file->getRealPath();
            $employees = Excel::load($path, function ($reader) {
            })->get();

            if ($employees->count() != 0) {
                foreach ($employees as $employee) {
                    $firstname = $this->sanitizeFirstname($employee->firstname);
                    $suffix = $this->getSuffix($employee->firstname);

                    $employee = Employee::updateOrCreate(
                        [
                            'id_number' => $employee->id_number,
                        ],
                        [
                            'id_number' => $employee->id_number,
                            'firstname' => ucwords($firstname),
                            'middlename' => ucwords($employee->middlename),
                            'lastname' => ucwords($employee->lastname),
                            'suffix' => $suffix,
                        ]
                    );

                    $user = $this->createUser($employee);

                    $user->syncRoles([5]);
                }
            }

            return redirect()->back()->with(['success_message' => 'Employees Uploaded Successfully']);
        }

        return response()->json('Failed to Upload');
    }

    // API endpoint for Dropdown Options
    public function options()
    {
        $roles = Role::whereNotIn('id', [3, 6])->select('display_name', 'id')->get();
        $programs = Program::select('name', 'id')->get();

        $options = [
            'roles' => $roles,
            'programs' => $programs,
        ];

        return response()->json($options);
    }

    private function createUser($employee)
    {
        $username = $employee->generateUsername();

        $user = User::updateOrCreate(
            [
                'username' => $username,
            ],
            [
                'username' => $username,
                'firstname' => $employee->firstname,
                'lastname' => $employee->lastname,
                'id_number' => $employee->id_number,
                'password' => $employee->generatePassword(),
            ]
        );

        return $user;
    }

    private function updateUser($id, $id_number)
    {
        $employee = Employee::find($id);
        $new_username = $employee->generateUsername();
        $password = $employee->generatePassword();

        $user = User::updateOrCreate(
            [
                'id_number' => $id_number,
            ],
            [
                'username' => $new_username,
                'firstname' => $employee->firstname,
                'lastname' => $employee->lastname,
                'password' => $password,
            ]
        );

        return $user;
    }

    private function getSuffix($value)
    {
        if (ends_with($value, 'Jr.')):
            return 'Jr.'; elseif (ends_with($value, ' Iii')):
            return 'III'; elseif (ends_with($value, ' Ii')):
            return 'II'; elseif (ends_with($value, ' Iv')):
            return 'IV'; else:
            return null;
        endif;
    }

    private function sanitizeFirstname($value)
    {
        if (ends_with($value, ' Jr.')):
            return ucwords(rtrim($value, 'Jr.')); elseif (ends_with($value, ' Iii')):
            return ucwords(rtrim($value, 'Iii')); elseif (ends_with($value, ' Ii')):
            return ucwords(rtrim($value, 'Ii')); elseif (ends_with($value, ' Iv')):
            return ucwords(rtrim($value, 'Iv')); else:
            return ucwords($value);
        endif;
    }
}
