<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Fetch the authenticated user's details.
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }
}
