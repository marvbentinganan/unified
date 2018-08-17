<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Digihub\Digihub;

class DigihubController extends Controller
{
    public function record(Request $request, Digihub $digihub)
    {
        $record = $digihub->usage()->create($request->all());
    }
}
