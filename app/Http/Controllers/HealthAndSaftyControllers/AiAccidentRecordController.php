<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Repositories\All\AccidentRecord\AccidentRecordInterface;
use App\Http\Requests\AccidentRecord\AccidentRecordRequest;
use Illuminate\Http\JsonResponse;

class AiAccidentRecordController extends Controller
{
    protected $accidentRecordInterface;

    public function __construct(AccidentRecordInterface $accidentRecordInterface)
    {
        $this->accidentRecordInterface = $accidentRecordInterface;
    }

    public function index(): JsonResponse
    {
        $records = $this->accidentRecordInterface->All();
        return response()->json($records);
    }

    public function store(AccidentRecordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $record = $this->accidentRecordInterface->create($data);
        return response()->json($record, 201);
    }

    public function show(string $id): JsonResponse
    {
        $record = $this->accidentRecordInterface->findById($id);
        return response()->json($record);
    }

    public function update(AccidentRecordRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();
        $record = $this->accidentRecordInterface->update($id, $data);
        return response()->json($record);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->accidentRecordInterface->deleteById($id);
        return response()->json(null, 204);
    }
}
