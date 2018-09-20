<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Digihub\Digihub;
use Carbon\Carbon;

class DigihubController extends Controller
{
    public function guidelines()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $digihub = Digihub::where('ip', 'like', $ip)->first();

        if ($digihub != null) {
            // $recent = $digihub->usages()->latest()->first();
            // if ($recent->created_at->diffInRealMinutes(now()) >= 2700) {
            $usage = $digihub->usages()->create();
            // }
        }

        return view('digihub.guidelines');
    }

    public function add(Request $request)
    {
        $digihub = Digihub::create($request->all());

        return response()->json('Digihub Added', 200);
    }

    public function get(Digihub $digihub)
    {
        return response()->json($digihub);
    }

    public function list()
    {
        $digihubs = Digihub::latest()->get();

        return response()->json($digihubs);
    }

    public function update(Request $request, Digihub $digihub)
    {
        $digihub->update([
            'name' => $request->name,
            'ip' => $request->ip,
            'location' => $request->location,
        ]);

        return response()->json('Digihub Updated', 200);
    }

    public function destroy($id)
    {
        $digihub = Digihub::find($id);
        $digihub->delete();

        return response()->json('Digihub Deleted', 200);
    }

    public function log(Request $request, Digihub $digihub)
    {
        if ($request->has('from')) {
            //dd($request);
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);

            $logs = $digihub->usages()
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->paginate(10);
        } else {
            $logs = $digihub->usages()->latest()->paginate(10);
        }

        //return response()->json($digihub);
        return view('digihub.log', compact('digihub', 'logs'));
    }
}
