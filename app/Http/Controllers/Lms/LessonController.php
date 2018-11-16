<?php

namespace App\Http\Controllers\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Build\Subject;
use App\Models\Build\Department;
use App\Models\Build\Program;
use App\Models\Lms\Lesson;

class LessonController extends Controller
{
    protected $directory;

    public function __construct()
    {
        $this->directory = 'faculty.lessons';
    }

    public function index()
    {
        if (auth()->user()->hasRole('faculty')) {
            $lessons = auth()->user()->lessons()->with(['department', 'program', 'subject'])->get();
        } elseif (auth()->user()->hasRole('management')) {
            $programs = auth()->user()->employee()->programs()->pluck('id');
            $lessons = Lesson::whereIn('program_id', $programs)->with(['departments', 'programs', 'subjects'])->get();
        } else {
            $lessons = Lesson::with(['department', 'program', 'subject'])->get();
        }

        return view($this->directory.'.index', compact('lessons'));
    }

    public function new()
    {
        $subjects = Subject::pluck('code', 'id');
        $departments = Department::pluck('name', 'id');
        $programs = Program::pluck('code', 'id');

        return view($this->directory.'.new', compact('subjects', 'departments', 'programs'));
    }

    public function store(Request $request)
    {
        try {
            $lesson = Lesson::updateOrCreate(
                [
                    'subject_id' => $request->subject_id,
                    'department_id' => $request->department_id,
                    'program_id' => $request->program_id,
                ],
                [
                    'title' => $request->title,
                    'slug' => str_slug($request->title, '-'),
                    'subject_id' => $request->subject_id,
                    'department_id' => $request->department_id,
                    'program_id' => $request->program_id,
                    'objective' => $request->objective,
                    'description' => $request->description,
                    'user_id' => auth()->user()->id,
                ]
            );

            if ($lesson) {
                //return redirect()->route('chapter.add', $lesson->slug);
                return response()->json('Lesson Added', 200);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function list()
    {
        $lessons = Lesson::where('user_id', auth()->user()->id)->latest()->get();

        return view($this->directory.'.list', compact('lessons'));
    }

    // Update Lesson
    public function update(Request $request, Lesson $lesson)
    {
        if($request->has('title')){
            $lesson->update([
                'title' => $request->title,
                'slug' => str_slug($request->title, '-'),
                'department_id' => $request->department_id,
                'program_id' => $request->program_id,
                'subject_id' => $request->subject_id,
                'description' => $request->description,
                'objective' => $request->objective
            ]);

            return redirect()->back();
        }

        $subjects = Subject::pluck('code', 'id');
        $departments = Department::pluck('name', 'id');
        $programs = Program::pluck('code', 'id');

        return view($this->directory.'.update', compact('subjects', 'departments', 'programs', 'lesson'));
    }
}