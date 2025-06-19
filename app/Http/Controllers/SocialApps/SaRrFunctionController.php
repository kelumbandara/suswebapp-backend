<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrFunction\RrFunctionRequest;
use App\Repositories\All\SaRrFunction\RrFunctionInterface;
use Illuminate\Http\Request;

class SaRrFunctionController extends Controller
{
    protected $rrFunctionInterface;

    public function __construct(RrFunctionInterface $rrFunctionInterface)
    {
        $this->rrFunctionInterface = $rrFunctionInterface;
    }

    public function index()
    {
        $function = $this->rrFunctionInterface->All();
        if ($function->isEmpty()) {
            return response()->json([
                'message' => 'No Function found.',
            ]);
        }
        return response()->json($function);
    }

    public function store(RrFunctionRequest $request)
    {
        $function = $this->rrFunctionInterface->create($request->validated());

        return response()->json([
            'message'  => 'Function created successfully!',
            'function' => $function,
        ], 201);
    }
}
