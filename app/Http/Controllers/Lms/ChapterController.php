<?php

namespace App\Http\Controllers\Lms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lms\Lesson;
use App\Models\Lms\Chapter;

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
            $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);

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

    public function update(Request $request, Lesson $lesson, Chapter $chapter)
    {
        if ($request->has('content')) {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
            ]);

            $chapter->update([
                'title' => $request->title,
                'slug' => str_slug($request->title, '-'),
                'content' => $request->content,
            ]);

            return response()->json('Chapter Updated', 200);
        }

        return view($this->directory.'.update', compact('chapter', 'lesson'));
    }

    public function list(Lesson $lesson)
    {
        return view($this->directory.'.list', compact('lesson'));
    }
}
