<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsOhMrBenefitRequest\BenefitRequest;
use App\Repositories\All\HsOhMrBenefitDocument\BenefitDocumentInterface;
use App\Repositories\All\HsOhMrBenefitEntitlement\BenefitEntitlementInterface;
use App\Repositories\All\OhMrBenefitRequest\BenefitRequestInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\BenefitDocumentService;
use Illuminate\Support\Facades\Auth;

class OhMrBenefitRequestController extends Controller
{

    protected $benefitRequestInterface;
    protected $benefitDocumentInterface;
    protected $benefitEntitlementInterface;
    protected $userInterface;
    protected $benefitDocumentService;

    public function __construct(BenefitRequestInterface $benefitRequestInterface, BenefitDocumentInterface $benefitDocumentInterface, BenefitEntitlementInterface $benefitEntitlementInterface, UserInterface $userInterface, BenefitDocumentService $benefitDocumentService)
    {
        $this->benefitRequestInterface     = $benefitRequestInterface;
        $this->benefitDocumentInterface    = $benefitDocumentInterface;
        $this->benefitEntitlementInterface = $benefitEntitlementInterface;
        $this->userInterface               = $userInterface;
        $this->benefitDocumentService      = $benefitDocumentService;

    }
    public function index()
    {
        $records = $this->benefitRequestInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();
        $records = $records->map(function ($record) {
            try {
                $creator                   = $this->userInterface->getById($record->createdByUser);
                $record->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $record->createdByUserName = 'Unknown';
            }
            return $record;
        });

        foreach ($records as $record) {
            $record->benefitsAndEntitlements = $this->benefitEntitlementInterface->findByBenefitId($record->id);
            $record->medicalDocuments        = $this->benefitDocumentInterface->findByBenefitId($record->id);

            if (! empty($record->medicalDocuments)) {
                foreach ($record->medicalDocuments as $doc) {
                    if (! empty($doc->document['gsutil_uri'])) {
                        $filePath  = $doc->document['gsutil_uri'];
                        $signedUrl = $this->benefitDocumentService->getImageUrl($filePath);
                        $fileName  = basename($filePath);

                        $doc->document = [
                            "gsutil_uri" => $filePath,
                            "imageUrl"   => $signedUrl,
                            "fileName"   => $fileName,
                        ];
                    }
                }
            }
        }

        return response()->json($records, 200);
    }

    public function store(BenefitRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;

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
            foreach ($data['medicalDocuments'] as $index => &$documents) {
                $documents['benefitId'] = $record->id;

                if ($request->hasFile("medicalDocuments.{$index}.document") && $request->file("medicalDocuments.{$index}.document")->isValid()) {
                    $documents['document'] = $this->benefitDocumentService->uploadImageToGCS(
                        $request->file("medicalDocuments.{$index}.document")
                    );
                } else {
                    $documents['document'] = null;
                }

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

        if (! $record) {
            return response()->json(['message' => 'Benefit request not found'], 404);
        }

        if (! $record->update($data)) {
            return response()->json(['message' => 'Failed to update benefit request'], 500);
        }

        $this->benefitEntitlementInterface->deleteByBenefitId($id);
        $this->benefitDocumentInterface->deleteByBenefitId($id);

        if (! empty($data['benefitsAndEntitlements'])) {
            foreach ($data['benefitsAndEntitlements'] as $entitlement) {
                $entitlement['benefitId'] = $id;
                $this->benefitEntitlementInterface->create($entitlement);
            }
        }

        if (! empty($data['medicalDocuments'])) {
            foreach ($data['medicalDocuments'] as $index => &$document) {
                $document['benefitId'] = $id;

                if (! empty($document['removeDoc']) && is_array($document['removeDoc'])) {
                    foreach ($document['removeDoc'] as $removeDoc) {
                        if (! empty($removeDoc)) {
                            $this->benefitDocumentService->removeOldDocumentFromStorage($removeDoc);
                        }
                }

                if ($request->hasFile("medicalDocuments.{$index}.document") && $request->file("medicalDocuments.{$index}.document")->isValid()) {
                    $uploadedDocument = $this->benefitDocumentService->uploadImageToGCS($request->file("medicalDocuments.{$index}.document"));
                    $document['document'] = $uploadedDocument['gsutil_uri'];
                } else {
                    $document['document'] = null;
                }

                $this->benefitDocumentInterface->create($document);
            }
        }

        $updatedRecord = $this->benefitRequestInterface->findById($id);
        $updatedRecord->entitlements = $this->benefitEntitlementInterface->findByBenefitId($id);
        $updatedRecord->documents = $this->benefitDocumentInterface->findByBenefitId($id);

        return response()->json([
            'message' => 'Benefit request updated successfully',
            'record' => $updatedRecord,
        ], 200);
    }
    }

    public function destroy(string $id)
    {
        $record = $this->benefitRequestInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Benefit request not found']);
        }

        $documents = $this->benefitDocumentInterface->findByBenefitId($id);
        if ($documents) {
            foreach ($documents as $doc) {
                if (! empty($doc->document['gsutil_uri'])) {
                    $this->benefitDocumentService->deleteImageFromGCS($doc->document['gsutil_uri']);
                }
            }
        }

        $this->benefitEntitlementInterface->deleteByBenefitId($id);

        $this->benefitRequestInterface->deleteById($id);

        return response()->json(['message' => 'Benefit request deleted successfully'], 200);
    }

}
