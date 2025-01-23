<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessType\ProcessTypeRequest;
use App\Repositories\All\ProcessType\ProcessTypeInterface;

class ProcessTypeController extends Controller
{
    protected $processTypeInterface;

    public function __construct(ProcessTypeInterface $processTypeInterface)
    {
        $this->processTypeInterface = $processTypeInterface;
    }


    public function show()
    {
        $processType = $this->processTypeInterface->All();

        if ($processType->isEmpty()) {
            return response()->json([
                'message' => 'No ProcessType found.',
            ], 404);
        }

        return response()->json($processType);
    }


    public function store(ProcessTypeRequest $request)
    {
        $validatedData = $request->validated();
        $processType = $this->processTypeInterface->create($validatedData);

        return response()->json([
            'message'    => 'ProcessType created successfully!',
            'processType' => $processType,
        ], 201);
    }
}


