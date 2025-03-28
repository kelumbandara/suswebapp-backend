<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIAccidentType\AccidentTypeRequest;
use App\Repositories\All\AccidentType\AccidentTypeInterface;

class AiAccidentTypeController extends Controller
{
    protected $accidentTypeInterface;

    public function __construct(AccidentTypeInterface $accidentTypeInterface)
    {
        $this->accidentTypeInterface = $accidentTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accidentType = $this->accidentTypeInterface->all();
        return response()->json($accidentType);
    }

    public function store(AccidentTypeRequest $request)
    {
        $data         = $request->validated();
        $accidentType = $this->accidentTypeInterface->create($data);
        return response()->json([
            'message' => 'Accident category created successfully',
            'data'    => $accidentType,
        ], 201);
    }

}
