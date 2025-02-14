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
     * Update the specified resource in storage.
     */
    public function update(IncidentRecodeRequest $request, string $id)
{
    $data = $request->validated();
    $record = $this->incidentRecordInterface->findById($id);

    if (!$record || !is_object($record)) {
        return response()->json(['message' => 'Incident record not found']);
    }

    // Update the main incident record itself
    $updateSuccess = $record->update($data); // Update the incident record in the database

    if (!$updateSuccess) {
        return response()->json(['message' => 'Failed to update incident record'], 500);
    }

    // Delete old witnesses and individuals if any
    $this->incidentWitnessInterface->deleteByIncidentId($id);
    $this->incidentPeopleInterface->deleteByIncidentId($id);

    // Insert updated witnesses if provided
    if (!empty($data['witnesses'])) {
        foreach ($data['witnesses'] as $witness) {
            $witness['incidentId'] = $id;
            $this->incidentWitnessInterface->create($witness);
        }
    }

    // Insert updated effected individuals if provided
    if (!empty($data['effectedIndividuals'])) {
        foreach ($data['effectedIndividuals'] as $person) {
            $person['incidentId'] = $id;
            $this->incidentPeopleInterface->create($person);
        }
    }

    // Reload the updated record including relationships
    $updatedRecord = $this->incidentRecordInterface->findById($id);
    $updatedRecord->witnesses = $this->incidentWitnessInterface->findByIncidentId($id);
    $updatedRecord->effectedIndividuals = $this->incidentPeopleInterface->findByIncidentId($id);

    return response()->json([
        'message' => 'Incident record updated successfully',
        'record'  => $updatedRecord,
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = $this->incidentRecordInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Incident record not found']);
        }

        $this->incidentWitnessInterface->deleteByIncidentId($id);

        $this->incidentPeopleInterface->deleteByIncidentId($id);

        $this->incidentRecordInterface->deleteById($id);

        return response()->json(['message' => 'Incident record deleted successfully'], 200);
    }
}
