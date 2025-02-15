<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMrBenefitRequest\BenefitRequest;
use App\Repositories\All\HsOhMrBenefitDocument\BenefitDocumentInterface;
use App\Repositories\All\HsOhMrBenefitEntitlement\BenefitEntitlementInterface;
use App\Repositories\All\OhMrBenefitRequest\BenefitRequestInterface;

class OhMrBenefitRequestController extends Controller
{

    protected $benefitRequestInterface;
    protected $benefitDocumentInterface;
    protected $benefitEntitlementInterface;

    public function __construct(BenefitRequestInterface $benefitRequestInterface, BenefitDocumentInterface $benefitDocumentInterface, BenefitEntitlementInterface $benefitEntitlementInterface)
    {
        $this->benefitRequestInterface     = $benefitRequestInterface;
        $this->benefitDocumentInterface    = $benefitDocumentInterface;
        $this->benefitEntitlementInterface = $benefitEntitlementInterface;
    }
    public function index()
    {
        $records = $this->benefitRequestInterface->All();

        foreach ($records as $record) {
            $record->benefitsAndEntitlements = $this->benefitEntitlementInterface->findByBenefitId($record->id);
            $record->medicalDocuments        = $this->benefitDocumentInterface->findByBenefitId($record->id);
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

        if (! empty($data['benefitsAndEntitlements'])) {
            foreach ($data['benefitsAndEntitlements'] as $entitlements) {
                $entitlements['benefitId'] = $record->id;
                $this->benefitEntitlementInterface->create($entitlements);
            }
        }

        if (! empty($data['medicalDocuments'])) {
            foreach ($data['medicalDocuments'] as $documents) {
                $documents['benefitId'] = $record->id;
                $this->benefitDocumentInterface->create($documents);
            }
        }

        return response()->json([
            'message' => 'Benefit request created successfully',
            'record'  => $record,
        ], 201);
    }

    public function update(BenefitRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->benefitRequestInterface->findById($id);

        if (! $record || ! is_object($record)) {
            return response()->json(['message' => 'Benefit request not found']);
        }

        $updateSuccess = $record->update($data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update benefit request'], 500);
        }

        $this->benefitEntitlementInterface->deleteByBenefitId($id);
        $this->benefitDocumentInterface->deleteByBenefitId($id);

        if (! empty($data['benefitsAndEntitlements'])) {
            foreach ($data['benefitsAndEntitlements'] as $entitlements) {
                $entitlements['benefitId'] = $id;
                $this->benefitEntitlementInterface->create($entitlements);
            }
        }

        if (! empty($data['medicalDocuments'])) {
            foreach ($data['medicalDocuments'] as $documents) {
                $documents['benefitId'] = $id;
                $this->benefitDocumentInterface->create($documents);
            }
        }

        $updatedRecord               = $this->benefitRequestInterface->findById($id);
        $updatedRecord->entitlements = $this->benefitEntitlementInterface->findByBenefitId($id);
        $updatedRecord->documents    = $this->benefitDocumentInterface->findByBenefitId($id);

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

        $this->benefitEntitlementInterface->deleteByBenefitId($id);

        $this->benefitDocumentInterface->deleteByBenefitId($id);

        $this->benefitRequestInterface->deleteById($id);

        return response()->json(['message' => 'Benefit request deleted successfully'], 200);
    }
}
