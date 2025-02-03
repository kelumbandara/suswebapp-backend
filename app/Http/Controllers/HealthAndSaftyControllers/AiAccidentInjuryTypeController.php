<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIAccidentInjuryType\AccidentInjuryTypeRequest;
use App\Repositories\All\AccidentInjuryType\AccidentInjuryTypeInterface;

class AiAccidentInjuryTypeController extends Controller
{
    protected $accidentInjuryTypeInterface;


    public function __construct(AccidentInjuryTypeInterface $accidentInjuryTypeInterface)
    {
        $this->accidentInjuryTypeInterface = $accidentInjuryTypeInterface;
    }

    public function index()
    {
        $accidentInjuryType = $this->accidentInjuryTypeInterface->all();
        return response()->json($accidentInjuryType);
    }


    public function store(AccidentInjuryTypeRequest $request)
    {
        $data = $request->validated();
        $accidentInjuryType = $this->accidentInjuryTypeInterface->create($data);
        return response()->json([
            'message' => 'Accident injury created successfully',
            'data' => $accidentInjuryType
        ], 201);
    }

}
