<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index()
    {
        return view('users.students');
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

        $student = Student::updateOrCreate([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffix' => $request->suffix,
            'date_of_birth' => $date_of_birth,
            'id_number' => $request->id_number,
            'barcode' => $barcode,
            'department_id' => $department,
        ]);

        return response()->json('Student Added', 200);
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
                    if (starts_with($student->id_number, 'SHS') == true) {
                        $id_now = substr_replace($student->id_number, '-', 7, 0);
                        $group_id = 2;
                    } else {
                        $id_now = $student->id_number;
                        $group_id = 1;
                    }
                    $user = Student::updateOrCreate(
                        [
                            'id_number' => $student->id_number,
                        ],
                        [
                            'id_number' => $student->id_number,
                            'id_now' => $id_now,
                            'firstname' => ucwords($student->firstname),
                            'middlename' => ucwords($student->middlename),
                            'lastname' => ucwords($student->lastname),
                            'group_id' => $group_id,
                        ]
                    );
                }
            }

            return Redirect::back()->with(['success_message' => 'Faculty Uploaded Successfully']);
        }

        return response()->json('Failed to Upload');
    }

    public function get()
    {
        $students = Student::with(['department'])->latest()->get();

        return response()->json($students);
    }
}
