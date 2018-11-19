<?php

namespace App\Http\Controllers\Build;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;

class ProgramController extends Controller
{
    protected $directory;
    protected $departments;

    public function __construct()
    {
        $this->directory = 'builds.programs';
        $this->departments = Department::get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->directory.'.index');
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
    public function store(Request $request, Program $program)
    {
        try {
            $request->validate([
                'name' => 'required',
                'code' => 'required',
                'department_id' => 'required',
            ]);

            $program = Program::create([
                'name' => $request->name,
                'code' => $request->code,
                'department_id' => $request->department_id,
            ]);

            return response()->json('Program Added', 200);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        return view($this->directory.'.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        $departments = $this->departments->pluck('name', 'id');

        $result = [
            'program' => $program,
            'departments' => $departments,
        ];

        return response()->json('result');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'department_id' => 'required',
        ]);

        $program->update([
            'name' => $request->name,
            'code' => $request->code,
            'department_id' => $request->department_id,
        ]);

        return response()->json('Program Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return response()->json('Program Deleted', 200);
    }

    public function restore($id)
    {
        $program = Program::where('id', $id)->withTrashed()->first();

        $program->restore();

        return response()->json('Program Restored', 200);
    }
}
