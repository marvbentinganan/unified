<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Digihub\Digihub;
use Carbon\Carbon;
// Charts
use App\Charts\DigihubWeeklyUsage;

class DigihubController extends Controller
{
    public function guidelines()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $digihub = Digihub::where('ip', 'like', $ip)->first();

        if ($digihub != null) {
            $recent = $digihub->usages()->latest()->first();
            if ($recent == null) {
                $usage = $digihub->usages()->create();
            } else {
                if ($recent->created_at->diffInRealMinutes(Carbon::now()) >= 45) {
                    $usage = $digihub->usages()->create();
                }
            }
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
            $from = Carbon::parse($request->from);
            $to = Carbon::parse($request->to);

            $logs = $digihub->usages()
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->paginate(10);
        } else {
            $logs = $digihub->usages()->distinct()->latest()->paginate(10);
        }

        $data = collect([]); // Could also be an array
        $labels = collect([]);

        for ($days_backwards = 6; $days_backwards >= 0; --$days_backwards) {
            // Could also be an array_push if using an array rather than a collection.
            $data->push($digihub->usages()->distinct()->whereDate('created_at', today()->subDays($days_backwards))->count());
            $labels->push(today()->subDays($days_backwards)->toFormattedDateString());
        }

        $chart = new DigihubWeeklyUsage();
        $chart->labels($labels);
        $chart->dataset('Last 7 Days', 'bar', $data)->options([
            'color' => '#f6bb42',
            'backgroundColor' => '#4a89dc',
            'lineTension' => 0.5,
        ]);

        return view('digihub.log', compact('digihub', 'logs', 'chart'));
    }
}
