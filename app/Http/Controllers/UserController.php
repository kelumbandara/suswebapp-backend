<?php

namespace App\Http\Controllers;

use App\Repositories\All\User\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

        public function show(Request $request)
    {
        return response()->json($request->user());
    }

}
