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
        try {
            // Set Variables
            $date_of_birth = Carbon::parse($request->date_of_birth)->toDateString();
            if (starts_with($request->id_number, 'SHS') == true) {
                $barcode = substr_replace($request->id_number, '-', 7, 0);
                $department = 1;
            } else {
                $barcode = $request->id_number;
                $department = 2;
            }

            $student = Student::create([
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffix' => $request->suffix,
                'date_of_birth' => $date_of_birth,
                'id_number' => $request->id_number,
                'barcode' => $barcode,
                'department_id' => $department,
            ]);

            if ($student) {
                $this->createUser($student);
            }

            return response()->json('Student Added', 200);
        } catch (Exception $exception) {
            return response()->json('Unable to Add Student', 500);
        }
    }

    public function upload(Request $request)
    {
        ini_set('max_execution_time', 900);

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

                    $firstname = $this->sanitizeFirstname($student->firstname);

                    $suffix = $this->getSuffix($student->firstname);

                    $student = Student::updateOrCreate(
                        [
                            'id_number' => $student->id_number,
                        ],
                        [
                            'id_number' => $student->id_number,
                            'barcode' => $barcode,
                            'firstname' => ucwords($firstname),
                            'middlename' => ucwords($student->middlename),
                            'lastname' => ucwords($student->lastname),
                            'suffix' => $suffix,
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

    public function update(Request $request, Student $student)
    {
        try {
            $date_of_birth = Carbon::parse($request->date_of_birth)->toDateString();
            if (starts_with($request->id_number, 'SHS') == true) {
                $barcode = substr_replace($request->id_number, '-', 7, 0);
                $department = 1;
            } else {
                $barcode = $request->id_number;
                $department = 2;
            }

            $student->update([
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffix' => $request->suffix,
                'date_of_birth' => $date_of_birth,
                'id_number' => $request->id_number,
                'barcode' => $barcode,
                'department_id' => $department,
            ]);

            $student->user()->update([
                'password' => $student->generatePassword(),
            ]);

            return response()->json('Student Updated', 200);
        } catch (Exception $exception) {
            return response()->json('Unable to Update Student', 500);
        }
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
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
                'id_number' => $student->id_number,
                'password' => $student->generatePassword(),
            ]
        );

        $user->syncRoles([$this->role]);
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
