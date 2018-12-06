<?php

namespace App\Http\Controllers\Lms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyClass;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    public function join(Request $request)
    {
        try {
            $student = auth()->user()->student;
            $class = MyClass::where('code', $request->code)->first();

            if (!$class->students->contains($student->id)) {
                $class->students()->attach($student->id);

                return response()->json('Student Added to Class', 200);
            } else {
                return response()->json('Student Already Added', 200);
            }

            return response()->json($class);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function list()
    {
        $student = auth()->user()->student;
        $classes = $student->classes;

        return response()->json($classes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
