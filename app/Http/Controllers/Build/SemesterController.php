<?php

namespace App\Http\Controllers\Build;

use App\Models\Build\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    protected $directory;

    public function __construct()
    {
        $this->directory = 'resources.semesters';
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $semester = Semester::create([
                'name' => $request->name,
            ]);

            return response()->json('Semester Added', 200);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Build\Semester $semester
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Build\Semester $semester
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Semester $semester)
    {
        return response()->json($semester);
    }

    public function list()
    {
        $semesters = Semester::withTrashed()->get();

        return response()->json($semesters);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \App\Models\Build\Semester $semester
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $semester->update([
            'name' => $request->name,
        ]);

        return response()->json('Semester Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Build\Semester $semester
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();

        return response()->json('Semester Deleted');
    }

    public function restore($id)
    {
        $semester = Semester::where('id', $id)->withTrashed()->first();
        $semester->restore();

        return response()->json('Semester Restored');
    }
}
