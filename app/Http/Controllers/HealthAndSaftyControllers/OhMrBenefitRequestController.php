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
            return response()->json(['message' => 'No accident records found']);
        }

        foreach ($records as $record) {
            $record->entitlement           = $this->benefitEntitlementInterface->findByBenefitRequestId($record->id);
            $record->documents = $this->benefitDocumentInterface->findByBenefitRequestId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(BenefitRequest $request)
    {

        $data   = $request->validated();
        $record = $this->benefitRequestInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create benefit request'], 500);
        }

        if (! empty($data['entitlement'])) {
            foreach ($data['entitlement'] as $entitlement) {
                $entitlement['benefitRequestId'] = $record->id;
                $this->benefitEntitlementInterface->create($entitlement);
            }
        }

        if (! empty($data['documents'])) {
            foreach ($data['documents'] as $documents) {
                $documents['benefitRequestId'] = $record->id;
                $this->benefitDocumentInterface->create($documents);
            }
        }

        return response()->json([
            'message' => 'Benefit request created successfully',
            'record'  => $record,
        ], 201);
    }

    public function show(string $id)
    {
        $record = $this->benefitRequestInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Benefit request not found']);
        }
        return response()->json($record);
    }

    public function update(BenefitRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->benefitRequestInterface->findById($id);

        if (! $record || ! is_object($record)) {
            return response()->json(['message' => 'Benefit request not found']);
        }

        $updateSuccess = $this->benefitRequestInterface->update($id, $data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update benefit request'], 500);
        }

        $updatedRecord = $this->benefitRequestInterface->findById($id);

        if (! $updatedRecord || ! is_object($updatedRecord)) {
            return response()->json(['message' => 'Error fetching updated benefit request'], 500);
        }

        $this->benefitEntitlementInterface->deleteByBenefitRequestId($id);
        $this->benefitDocumentInterface->deleteByBenefitRequestId($id);

        if (! empty($data['entitlement'])) {
            foreach ($data['entitlement'] as $entitlement) {
                $entitlement['benefitRequestId'] = $id;
                $this->benefitEntitlementInterface->create($entitlement);
            }
        }

        if (! empty($data['documents'])) {
            foreach ($data['documents'] as $documents) {
                $documents['benefitRequestId'] = $id;
                $this->benefitDocumentInterface->create($documents);
            }
        }

        $updatedRecord->inventory           = $this->benefitEntitlementInterface->findByBenefitRequestId($id);
        $updatedRecord->effectedIndividuals = $this->benefitDocumentInterface->findByBenefitRequestId($id);

        return response()->json([
            'message' => 'Benefit request updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    public function destroy(string $id)
    {
        $record = $this->benefitRequestInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Benefit request not found']);
        }

        $this->benefitEntitlementInterface->deleteByBenefitRequestId($id);

        $this->benefitDocumentInterface->deleteByBenefitRequestId($id);

        $this->benefitRequestInterface->deleteById($id);

        return response()->json(['message' => 'Benefit request deleted successfully'], 200);
    }
}
