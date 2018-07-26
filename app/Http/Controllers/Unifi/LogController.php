<?php

namespace App\Http\Controllers\Unifi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unifi\AccessLog;

class LogController extends Controller
{
    protected $logs;
    protected $active_logs;

    public function __construct()
    {
        $this->logs = AccessLog::latest()
        ->with(['user'])
        ->paginate(15);

        $this->active_logs = AccessLog::where('expires_on', '>', now())
        ->orderBy('expires_on', 'desc')
        ->with(['user'])
        ->paginate(15);
    }

    public function index()
    {
        $logs = $this->logs;
        return view('logs.index', compact('logs'));
    }

    public function active()
    {
        $logs = AccessLog::where('expires_on', '>', now())
        ->orderBy('expires_on', 'desc')
        ->with(['user' => function ($query) {
            $query->with(['roles', 'group']);
        }])->get();

        return response()->json($logs);
    }

    public function search(Request $request)
    {
        $logs = AccessLog::where('ip', $request->keyword)
        ->orWhere('device', $request->keyword)
        ->orderBy('expires_on', 'desc')
        ->with(['user' => function ($query) {
            $query->with(['types', 'groups']);
        }])
        ->get();

        return response()->json($logs);
    }
}
