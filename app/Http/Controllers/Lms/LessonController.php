<?php

namespace App\Http\Controllers\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Build\Subject;
use App\Models\Build\Department;
use App\Models\Build\Program;
use App\Models\Build\Setting;
use App\Models\Lms\Lesson;

class LessonController extends Controller
{
    protected $directory;
    protected $global_settings;

    public function __construct()
    {
        $this->directory = 'faculty.lessons';
        $this->global_settings = Setting::first();
    }

    public function index()
    {
        if (auth()->user()->hasRole('management')) {
            $mine = auth()->user()->lessons()
            ->with(['department', 'program', 'subject'])
            ->latest()
            ->withTrashed()
            ->get();

            $all = Lesson::with(['department', 'program', 'subject'])
            ->forManagers()
            ->latest()
            ->withTrashed()
            ->get();

            return view($this->directory.'.index', compact('all', 'mine'));
        } elseif (auth()->user()->hasRole('faculty')) {
            $mine = auth()->user()->lessons()
            ->with(['department', 'program', 'subject'])
            ->latest()
            ->withTrashed()
            ->get();

            $all = null;

            return view($this->directory.'.index', compact('all', 'mine'));
        } elseif (auth()->user()->hasRole('administrator')) {
            $mine = null;

            $all = Lesson::with(['department', 'program', 'subject'])
            ->latest()
            ->withTrashed()
            ->get();

            return view($this->directory.'.index', compact('all', 'mine'));
        }
    }

    public function new()
    {
        return view($this->directory.'.new');
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

            $code = strtoupper(str_random(10));

            $lesson = auth()->user()->lessons()->create(
                [
                    'title' => $request->title,
                    'slug' => str_slug($request->title, '-'),
                    'code' => $code,
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

    // Get list of added Lessons
    public function list()
    {
        $lessons = Lesson::where('user_id', auth()->user()->id)
        ->with(['department', 'program', 'subject'])
        ->latest()
        ->get();

        return response()->json($lessons);
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
                'description' => trim($request->description),
                'objective' => trim($request->objective),
            ]);

            return response()->json('Lesson Updated', 200);
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
                'approved' => true,
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
                'approved' => false,
                'approved_by' => null,
            ]);

            return response()->json('Lesson Unpublished');
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
