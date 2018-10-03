<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function paginated()
    {
        $users = User::with(['roles'])->paginate(15);

        return response()->json($users);
    }
}
