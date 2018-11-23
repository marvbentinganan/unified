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
        if (auth()->user()->hasRole('management')) {
            $employee = auth()->user()->employee;
            $programs = $employee->programs;
            $lessons = Lesson::whereIn('program_id', $programs->pluck('id'))->with(['department', 'program', 'subject'])->withTrashed()->get();
        } elseif (auth()->user()->hasRole('faculty')) {
            $lessons = auth()->user()->lessons()->with(['department', 'program', 'subject'])->withTrashed()->get();
        } else {
            $lessons = Lesson::with(['department', 'program', 'subject'])->withTrashed()->get();
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
            $request->validate([
                'title' => 'required',
                'subject_id' => 'required',
                'department_id' => 'required',
                'program_id' => 'required',
            ]);

            $lesson = auth()->user()->lessons()->updateOrCreate(
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

    // View Lesson
    public function view(Lesson $lesson)
    {
        return view($this->directory.'.view', compact('lesson'));
    }

    public function list()
    {
        $lessons = Lesson::where('user_id', auth()->user()->id)->latest()->get();

        return view($this->directory.'.list', compact('lessons'));
    }

    // Update Lesson
    public function update(Request $request, Lesson $lesson)
    {
        if ($request->has('title')) {
            $lesson->update([
                'title' => $request->title,
                'slug' => str_slug($request->title, '-'),
                'department_id' => $request->department_id,
                'program_id' => $request->program_id,
                'subject_id' => $request->subject_id,
                'description' => $request->description,
                'objective' => $request->objective,
            ]);

            return redirect()->back();
        }

        $subjects = Subject::pluck('code', 'id');
        $departments = Department::pluck('name', 'id');
        $programs = Program::pluck('code', 'id');

        return view($this->directory.'.update', compact('subjects', 'departments', 'programs', 'lesson'));
    }

    public function destroy($lesson)
    {
        try {
            $data = Lesson::find($lesson);
            $data->delete();

            return response()->json('Lesson Deleted');
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function restore($lesson)
    {
        try {
            $data = Lesson::where('id', $lesson)->withTrashed()->first();
            $data->restore();

            return response()->json('Lesson Restored');
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function approve($lesson)
    {
        try {
            $data = Lesson::find($lesson);
            $data->update([
                'active' => true,
                'for_approval' => false,
                'approved_by' => auth()->user()->id,
            ]);

            return response()->json('Lesson Published');
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function disapprove($lesson)
    {
        try {
            $data = Lesson::find($lesson);
            $data->update([
                'active' => false,
                'for_approval' => true,
                'approved_by' => null,
            ]);

            return response()->json('Lesson Unpublished');
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
