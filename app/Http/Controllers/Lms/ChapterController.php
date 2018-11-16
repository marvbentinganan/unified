<?php

namespace App\Http\Controllers\Lms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Build\Subject;
use App\Models\Build\Department;
use App\Models\Build\Program;
use App\Models\Lms\Lesson;

class ChapterController extends Controller
{
    protected $directory;

    public function __construct()
    {
        $this->directory = 'faculty.lessons.chapters';
    }

    public function store(Request $request, Lesson $lesson)
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

        return view($this->directory.'.new', compact('lesson'));
    }

    public function update(Request $request, Chapter $chapter)
    {
        
    }

    public function list(Lesson $lesson)
    {
        return view($this->directory.'.list', compact('lesson'));
    }
}
