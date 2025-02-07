<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncidentRecode\IncidentRecodeRequest;
use App\Repositories\All\IncidentPeople\IncidentPeopleInterface;
use App\Repositories\All\IncidentRecord\IncidentRecodeInterface;
use App\Repositories\All\IncidentWitness\IncidentWitnessInterface;
use Illuminate\Http\Request;

class AiIncidentRecodeController extends Controller
{
    protected $incidentRecordInterface;
    protected $incidentWitnessInterface;
    protected $incidentPeopleInterface;
    public function __construct(IncidentRecodeInterface $incidentRecordInterface, IncidentWitnessInterface $incidentWitnessInterface, IncidentPeopleInterface $incidentPeopleInterface)
    {
        $this->incidentRecordInterface  = $incidentRecordInterface;
        $this->incidentWitnessInterface = $incidentWitnessInterface;
        $this->incidentPeopleInterface  = $incidentPeopleInterface;
    }


    public function index()
    {
        $records = $this->incidentRecordInterface->All();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No incident records found'], 404);
        }

        foreach ($records as $record) {
            $record->witnesses           = $this->incidentWitnessInterface->findByIncidentId($record->id);
            $record->effectedIndividuals = $this->incidentPeopleInterface->findByIncidentId($record->id);
        }

        return response()->json($records, 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function store(IncidentRecodeRequest $request)
    {

        $data   = $request->validated();
        $record = $this->incidentRecordInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create Incident record'], 500);
        }

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['incidentId'] = $record->id;
                $this->incidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['incidentId'] = $record->id;
                $this->incidentPeopleInterface->create($person);
            }
        }

        return response()->json([
            'message' => 'Incident record created successfully',
            'record'  => $record,
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
        $record = $this->incidentRecordInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Incident record not found'], 404);
        }

        $this->incidentWitnessInterface->deleteByIncidentId($id);

        $this->incidentPeopleInterface->deleteByIncidentId($id);

        $this->incidentRecordInterface->deleteById($id);

        return response()->json(['message' => 'Incident record deleted successfully'], 200);
    }
}
