<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AIAccidentPeople\AccidentPeopleRequest;
use App\Repositories\All\AccidentPeople\AccidentPeopleInterface;

class AiAccidentPeopleController extends Controller
{
    protected $accidentPeopleInterface;

    /**
     * Inject the AccidentPeopleInterface dependency.
     */
    public function __construct(AccidentPeopleInterface $accidentPeopleInterface)
    {
        $this->accidentPeopleInterface = $accidentPeopleInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = $this->accidentPeopleInterface->all();
        return response()->json($people);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccidentPeopleRequest $request)
    {
        $data = $request->validated();
        $person = $this->accidentPeopleInterface->create($data);
        return response()->json([
            'message' => 'Accident person created successfully',
            'data' => $person
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $person = $this->accidentPeopleInterface->findById($id);

        if (!$person) {
            return response()->json(['message' => 'Accident person not found'], 404);
        }

        return response()->json($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccidentPeopleRequest $request, string $id)
    {
        $data = $request->validated();
        $person = $this->accidentPeopleInterface->update($id, $data);

        if (!$person) {
            return response()->json(['message' => 'Failed to update accident person'], 400);
        }

        return response()->json([
            'message' => 'Accident person updated successfully',
            'data' => $person
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->accidentPeopleInterface->deleteById($id);

        if (!$deleted) {
            return response()->json(['message' => 'Accident person not found or could not be deleted'], 404);
        }

        return response()->json(['message' => 'Accident person deleted successfully'], 200);
    }
}
