<?php

namespace App\Http\Controllers\CommonControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPosition\JobPositionRequest;
use App\Repositories\All\ComJobPosition\JobPositionInterface;

class JobPositionController extends Controller
{
    protected $jobPositionInterface;

    public function __construct(JobPositionInterface $jobPositionInterface)
    {
        $this->jobPositionInterface = $jobPositionInterface;
    }

    public function index()
    {
        $jobPositions = $this->jobPositionInterface->All();
        if ($jobPositions->isEmpty()) {
            return response()->json([
                'message' => 'No jobPositions found.',
            ], 404);
        }
        return response()->json($jobPositions);
    }

    public function store(JobPositionRequest $request)
    {
        $jobPosition = $this->jobPositionInterface->create($request->validated());

        return response()->json([
            'message'    => 'JobPosition created successfully!',
            'department' => $jobPosition,
        ], 201);
    }
}
