<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIAccidentWitness\AccidentWitnessRequest;
use App\Repositories\All\AccidentWitness\AccidentWitnessInterface;
use Illuminate\Http\Request;

class AiAccidentWitnessController extends Controller
{
    protected $accidentWitnessInterface;

    public function __construct(AccidentWitnessInterface $accidentWitnessInterface)
    {
        $this->accidentWitnessInterface = $accidentWitnessInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $witnesses = $this->accidentWitnessInterface->All();
        return response()->json($witnesses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccidentWitnessRequest $request)
    {
        $data = $request->validated();
        $this->accidentWitnessInterface->create($data);
        return response()->json(['message' => 'Witness created successfully',$data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $witness = $this->accidentWitnessInterface->findById($id);
        if (!$witness) {
            return response()->json(['message' => 'Witness not found'], 404);
        }
        return response()->json($witness);
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->accidentWitnessInterface->deleteById($id); // Assuming a method to delete by ID
        if (!$deleted) {
            return response()->json(['message' => 'Witness not found or could not be deleted'], 404);
        }
        return response()->json(['message' => 'Witness deleted successfully'], 200);
    }
}
