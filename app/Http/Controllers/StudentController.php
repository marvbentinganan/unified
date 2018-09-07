<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Excel;

class StudentController extends Controller
{
    protected $role;

    public function __construct()
    {
        $this->role = Role::find(3);
    }

    public function index()
    {
        return view('users.students.index');
    }

    public function store(Request $request)
    {
        // Set Variables
        $date_of_birth = Carbon::parse($request->date_of_birth)->toDateString();
        if (starts_with($request->id_number, 'SHS') == true) {
            $barcode = substr_replace($request->id_number, '-', 7, 0);
            $department = 1;
        } else {
            $barcode = $request->id_number;
            $department = 2;
        }

        $student = Student::updateOrCreate(
            [
                'id_number' => $request->id_number,
            ],
            [
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffix' => $request->suffix,
                'date_of_birth' => $date_of_birth,
                'id_number' => $request->id_number,
                'barcode' => $barcode,
                'department_id' => $department,
            ]
        );

        $this->createUser($student);

        return response()->json('Success!', 200);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
            $path = $file->getRealPath();
            $students = Excel::load($path, function ($reader) {
            })->get();
            if ($students->count() != 0) {
                foreach ($students as $student) {
                    $date_of_birth = Carbon::parse($student->date_of_birth)->toDateString();
                    if (starts_with($student->id_number, 'SHS') == true) {
                        $barcode = substr_replace($student->id_number, '-', 7, 0);
                        $department_id = 1;
                    } else {
                        $barcode = $student->id_number;
                        $department_id = 2;
                    }

                    $student = Student::updateOrCreate(
                        [
                            'id_number' => $student->id_number,
                        ],
                        [
                            'id_number' => $student->id_number,
                            'barcode' => $barcode,
                            'firstname' => ucwords($student->firstname),
                            'middlename' => ucwords($student->middlename),
                            'lastname' => ucwords($student->lastname),
                            'suffix' => $student->suffix,
                            'date_of_birth' => $date_of_birth,
                            'department_id' => $department_id,
                        ]
                    );

                    $this->createUser($student);
                }
            }

            return redirect()->back()->with(['success_message' => 'Students Uploaded Successfully']);
        }

        return response()->json('Failed to Upload');
    }

    public function get()
    {
        $students = Student::with(['department'])
        ->orderBy('department_id')
        ->orderby('lastname')
        ->get();

        return response()->json($students);
    }

    public function edit(Student $student)
    {
        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json('Student Deleted', 200);
    }

    private function createUser($student)
    {
        $user = User::updateOrCreate(
            [
                'username' => $student->id_number,
            ],
            [
                'username' => $student->id_number,
                'firstname' => $student->firstname,
                'lastname' => $student->lastname,
                'password' => $student->generatePassword(),
            ]
        );

        $user->attachRole($this->role);
    }
}
