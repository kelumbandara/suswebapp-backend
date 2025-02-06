<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Repositories\All\AccidentRecord\AccidentRecordInterface;
use App\Http\Requests\AccidentRecord\AccidentRecordRequest;
use App\Repositories\All\AccidentPeople\AccidentPeopleInterface;
use App\Repositories\All\AccidentWitness\AccidentWitnessInterface;
use Illuminate\Http\JsonResponse;

class AiAccidentRecordController extends Controller
{
    protected $accidentRecordInterface;
    protected $accidentWitnessInterface;
    protected $accidentPeopleInterface;

    public function __construct(AccidentRecordInterface $accidentRecordInterface, AccidentWitnessInterface $accidentWitnessInterface, AccidentPeopleInterface $accidentPeopleInterface)
    {
        $this->accidentRecordInterface = $accidentRecordInterface;
        $this->accidentWitnessInterface = $accidentWitnessInterface;
        $this->accidentPeopleInterface = $accidentPeopleInterface;
    }

    public function index()
    {
        $records = $this->accidentRecordInterface->All();

        foreach ($records as $record) {
            $record->witnesses = $this->accidentWitnessInterface->findByAccidentId($record->id);
            $record->people = $this->accidentPeopleInterface->findByAccidentId($record->id);
        }

        return response()->json($records);
    }

    public function store(AccidentRecordRequest $request)
    {


        $data = $request->validated();
        $record = $this->accidentRecordInterface->create($data);

        if (!$record) {
            return response()->json(['message' => 'Failed to create accident record'], 500);
        }

        if (!empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $record->id;
                $this->accidentWitnessInterface->create($witness);
            }
        }

        if (!empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $record->id;
                $this->accidentPeopleInterface->create($person);
            }
        }

        return response()->json([
            'message' => 'Accident record created successfully',
            'record' => $record
        ], 201);
    }


    public function show(string $id)
    {
        $record = $this->accidentRecordInterface->findById($id);
        if (!$record) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }
        return response()->json($record);
    }

    public function update(AccidentRecordRequest $request, string $id)
    {
        $data = $request->validated();

        $record = $this->accidentRecordInterface->findById($id);

        if (!$record) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }

        $updatedRecord = $this->accidentRecordInterface->update($id, $data);

        if (!empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $id;
                $this->accidentWitnessInterface->updateOrCreate(
                    ['accidentId' => $id, 'employeeId' => $witness['employeeId']],
                    $witness
                );
            }
        }

        if (!empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $id;
                $this->accidentPeopleInterface->updateOrCreate(
                    ['accidentId' => $id, 'employeeId' => $person['employeeId'] ?? null],
                    $person
                );
            }
        }

        return response()->json([
            'message' => 'Accident record updated successfully',
            'data' => $updatedRecord
        ]);
    }


    public function destroy(string $id)
    {
        $this->accidentRecordInterface->deleteById($id);
        return response()->json(null, 204);
    }
}
