<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccidentRecord\AccidentRecordRequest;
use App\Repositories\All\AccidentPeople\AccidentPeopleInterface;
use App\Repositories\All\AccidentRecord\AccidentRecordInterface;
use App\Repositories\All\AccidentWitness\AccidentWitnessInterface;

class AiAccidentRecordController extends Controller
{
    protected $accidentRecordInterface;
    protected $accidentWitnessInterface;
    protected $accidentPeopleInterface;

    public function __construct(AccidentRecordInterface $accidentRecordInterface, AccidentWitnessInterface $accidentWitnessInterface, AccidentPeopleInterface $accidentPeopleInterface)
    {
        $this->accidentRecordInterface  = $accidentRecordInterface;
        $this->accidentWitnessInterface = $accidentWitnessInterface;
        $this->accidentPeopleInterface  = $accidentPeopleInterface;
    }

    public function index()
    {
        $records = $this->accidentRecordInterface->All();
        foreach ($records as $record) {
            $record->witnesses           = $this->accidentWitnessInterface->findByAccidentId($record->id);
            $record->effectedIndividuals = $this->accidentPeopleInterface->findByAccidentId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(AccidentRecordRequest $request)
    {

        $data   = $request->validated();
        $record = $this->accidentRecordInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create accident record'], 500);
        }

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $record->id;
                $this->accidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $record->id;
                $this->accidentPeopleInterface->create($person);
            }
        }

        return response()->json([
            'message' => 'Accident record created successfully',
            'record'  => $record,
        ], 201);
    }

    public function show(string $id)
    {
        $record = $this->accidentRecordInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Accident record not found']);
        }
        return response()->json($record);
    }

    public function update(AccidentRecordRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->accidentRecordInterface->findById($id);

        if (! $record || ! is_object($record)) {
            return response()->json(['message' => 'Accident record not found']);
        }

        $updateSuccess = $this->accidentRecordInterface->update($id, $data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update accident record'], 500);
        }

        $updatedRecord = $this->accidentRecordInterface->findById($id);

        if (! $updatedRecord || ! is_object($updatedRecord)) {
            return response()->json(['message' => 'Error fetching updated accident record'], 500);
        }

        $this->accidentWitnessInterface->deleteByAccidentId($id);
        $this->accidentPeopleInterface->deleteByAccidentId($id);

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $id;
                $this->accidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $id;
                $this->accidentPeopleInterface->create($person);
            }
        }

        $updatedRecord->witnesses           = $this->accidentWitnessInterface->findByAccidentId($id);
        $updatedRecord->effectedIndividuals = $this->accidentPeopleInterface->findByAccidentId($id);

        return response()->json([
            'message' => 'Accident record updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    public function destroy(string $id)
    {
        $record = $this->accidentRecordInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Accident record not found']);
        }

        $this->accidentWitnessInterface->deleteByAccidentId($id);

        $this->accidentPeopleInterface->deleteByAccidentId($id);

        $this->accidentRecordInterface->deleteById($id);

        return response()->json(['message' => 'Accident record deleted successfully'], 200);
    }

}
