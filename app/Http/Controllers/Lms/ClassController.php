<?php

namespace App\Http\Controllers\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Build\Subject;
use App\Models\Build\Department;
use App\Models\Build\Program;
use App\Models\Build\YearLevel;
use App\Models\Build\Setting;
use App\Models\Lms\Lesson;
use App\Models\MyClass;
use App\Models\Student;
use Excel;

class ClassController extends Controller
{
    protected $directory;
    protected $classes;
    protected $global_settings;

    public function __construct()
    {
        $this->directory = 'faculty.classes';
        $this->global_settings = Setting::first();
    }

    public function add(Request $request)
    {
        if ($request->has('section')) {
            try {
                // Check For Record
                $check = $this->checkRecord($request);

                if ($check == false) {
                    $code = strtoupper(str_random(5));

                    $class = MyClass::create([
                        'code' => $code,
                        'section' => $request->section,
                        'employee_id' => auth()->user()->employee->id,
                        'department_id' => $request->department_id,
                        'program_id' => $request->program_id,
                        'subject_id' => $request->subject_id,
                        'year_level_id' => $request->year_level_id,
                        'school_year_id' => $this->global_settings->school_year_id,
                        'semester_id' => $this->global_settings->semester_id,
                    ]);

                    // Generate Name
                    $name = $this->createName($class);
                    if ($name == true) {
                        return response()->json('New Class Added', 200);
                    } else {
                        return response()->json('Cannot Generate Name', 500);
                    }
                } else {
                    return response()->json('Class Already Exists', 500);
                }
            } catch (Exception $ex) {
                return $ex;
            }
        }

        return view($this->directory.'.add');
    }

    public function options()
    {
        $subjects = Subject::select('id', 'code', 'name')->get();
        $programs = Program::select('id', 'code', 'name', 'department_id')->get();
        $departments = Department::select('id', 'name')->get();
        $year_levels = YearLevel::select('id', 'name', 'department_id')->get();

        $options = [
            'subjects' => $subjects,
            'programs' => $programs,
            'departments' => $departments,
            'year_levels' => $year_levels,
        ];

        return response()->json($options);
    }

    public function myClasses()
    {
        return view($this->directory.'.my');
    }

    public function my_classes()
    {
        $classes = MyClass::where('employee_id', auth()->user()->employee->id)
        ->with(['department', 'program', 'subject'])
        ->get();

        return response()->json($classes);
    }

    public function view(MyClass $class)
    {
        if ($class->lessons->count() == null) {
            $lessons = Lesson::where('subject_id', $class->subject_id)
            ->where('department_id', $class->department_id)
            ->where('program_id', $class->program_id)
            ->where('active', true)
            ->get();
        } else {
            $lessons = $class->lessons;
        }

        //dd($lessons);

        return view($this->directory.'.view', compact('class', 'lessons'));
    }

    // Attach Lesson to Class
    public function attach(MyClass $class, $lesson)
    {
        $data = Lesson::find($lesson);
        try {
            $class->lessons()->sync($data->id);

            return response()->json('Lesson Added', 200);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    // Detach Lesson to Class
    public function detach(MyClass $class, $lesson)
    {
        $data = Lesson::find($lesson);
        try {
            $class->lessons()->detach($data->id);

            return response()->json('Lesson Removed', 200);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function upload(Request $request, MyClass $class)
    {
        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
            $path = $file->getRealPath();
            $students = Excel::load($path, function ($reader) {
            })->get();

            if ($students->count() != 0) {
                foreach ($students as $data) {
                    $student = Student::where('id_number', trim($data->id_number))->first();
                    if ($student) {
                        $student->classes()->attach([$class->id]);
                    }
                }
            }

            return redirect()->back()->with(['success_message' => 'Students Uploaded Successfully']);
        }

        return response()->json('Failed to Upload');
    }

    private function checkRecord($request)
    {
        $result = MyClass::where('subject_id', $request->subject_id)
        ->where('department_id', $request->department_id)
        ->where('program_id', $request->program_id)
        ->where('year_level_id', $request->year_level_id)
        ->where('school_year_id', $this->global_settings->school_year_id)
        ->where('semester_id', $this->global_settings->semester_id)
        ->first();

        if ($result) {
            return true;
        }

        return false;
    }

    private function createName($class)
    {
        $program = $class->program->code;
        $year_level = $class->year_level->name;
        $section = $class->section;
        $subject = $class->subject->code;

        $class_name = $program.'-'.$year_level.'-'.$section.'-'.$subject;

        // Update Class Name
        $class->update([
            'name' => $class_name,
        ]);

        return true;
    }
}
