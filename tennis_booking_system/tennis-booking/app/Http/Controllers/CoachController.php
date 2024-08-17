<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CoachController extends Controller
{
    public function getCoaches()
    {

        $users = User::where('role', 'coach')->get();
        return response()->json(['coaches' => $users]);
    }
}
