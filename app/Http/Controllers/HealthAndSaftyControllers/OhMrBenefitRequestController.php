<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMrBenefitRequest\BenefitRequest;
use App\Repositories\All\OhMrBenefitDocument\BenefitDocumentInterface;
use App\Repositories\All\OhMrBenefitEntitlement\BenefitEntitlementInterface;
use App\Repositories\All\OhMrBenefitRequest\BenefitRequestInterface;

class OhMrBenefitRequestController extends Controller
{
    protected $benefitRequestInterface;
    protected $benefitEntitlementInterface;
    protected $benefitDocumentInterface;

    public function __construct(BenefitRequestInterface $benefitRequestInterface, BenefitEntitlementInterface $benefitEntitlementInterface, BenefitDocumentInterface $benefitDocumentInterface)
    {
        $this->benefitRequestInterface  = $benefitRequestInterface;
        $this->benefitEntitlementInterface = $benefitEntitlementInterface;
        $this->benefitDocumentInterface  = $benefitDocumentInterface;
    }

    public function index()
    {
        $records = $this->benefitRequestInterface->All();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No accident records found'], 404);
        }

        foreach ($records as $record) {
            $record->witnesses           = $this->benefitEntitlementInterface->findByBenefitRequestId($record->id);
            $record->effectedIndividuals = $this->benefitDocumentInterface->findByBenefitRequestId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(BenefitRequest $request)
    {

        $data   = $request->validated();
        $record = $this->benefitRequestInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create accident record'], 500);
        }

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $record->id;
                $this->benefitEntitlementInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $record->id;
                $this->benefitDocumentInterface->create($person);
            }
        }

        return response()->json([
            'message' => 'Accident record created successfully',
            'record'  => $record,
        ], 201);
    }

    public function show(string $id)
    {
        $record = $this->benefitRequestInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }
        return response()->json($record);
    }

    public function update(BenefitRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->benefitRequestInterface->findById($id);

        if (! $record || ! is_object($record)) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }

        $updateSuccess = $this->benefitRequestInterface->update($id, $data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update accident record'], 500);
        }

        $updatedRecord = $this->benefitRequestInterface->findById($id);

        if (! $updatedRecord || ! is_object($updatedRecord)) {
            return response()->json(['message' => 'Error fetching updated accident record'], 500);
        }

        $this->benefitEntitlementInterface->deleteByBenefitRequestId($id);
        $this->benefitDocumentInterface->deleteByBenefitRequestId($id);

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $id;
                $this->benefitEntitlementInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $id;
                $this->benefitDocumentInterface->create($person);
            }
        }

        $updatedRecord->witnesses           = $this->benefitEntitlementInterface->findByBenefitRequestId($id);
        $updatedRecord->effectedIndividuals = $this->benefitDocumentInterface->findByBenefitRequestId($id);

        return response()->json([
            'message' => 'Accident record updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    public function destroy(string $id)
    {
        $record = $this->benefitRequestInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }

        $this->benefitEntitlementInterface->deleteByBenefitRequestId($id);

        $this->benefitDocumentInterface->deleteByBenefitRequestId($id);

        $this->benefitRequestInterface->deleteById($id);

        return response()->json(['message' => 'Accident record deleted successfully'], 200);
    }
}
