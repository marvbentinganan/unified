<?php

namespace App\Http\Controllers\Build;

use App\Models\Build\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolYearController extends Controller
{
    protected $directory;

    public function __construct()
    {
        $this->directory = 'resources.school_years';
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

            $department = SchoolYear::create([
                'name' => $request->name,
            ]);

            return response()->json('School Year Added', 200);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Build\SchoolYear $schoolYear
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYear $school_year)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Build\SchoolYear $schoolYear
     *
     * @return \Illuminate\Http\Response
     */
    public function get(SchoolYear $school_year)
    {
        return response()->json($school_year);
    }

    public function list()
    {
        $school_years = SchoolYear::withTrashed()->get();

        return response()->json($school_years);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request     $request
     * @param \App\Models\Build\SchoolYear $schoolYear
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolYear $school_year)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $school_year->update([
            'name' => $request->name,
        ]);

        return response()->json('School Year Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Build\SchoolYear $schoolYear
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYear $school_year)
    {
        $school_year->delete();

        return response()->json('School Year Deleted');
    }

    public function restore($id)
    {
        $school_year = SchoolYear::where('id', $id)->withTrashed()->first();
        $school_year->restore();

        return response()->json('School Year Restored');
    }
}
