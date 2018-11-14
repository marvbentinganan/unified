<?php

namespace App\Http\Controllers;

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
        return view($this->directory.'.index');
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

    public function add_chapter(Request $request, Lesson $lesson)
    {
        if ($request->has('content')) {
            try {
                $lesson->chapters()->create([
                    'title' => $request->title,
                    'slug' => str_slug($request->title, '-'),
                    'content' => $request->content,
                    'user_id' => auth()->user()->id,
                ]);

                return response()->json('Chapter Added', 200);
            } catch (Exception $ex) {
                return $ex;
            }
        }

        return view($this->directory.'.chapters.new', compact('lesson'));
    }
}
