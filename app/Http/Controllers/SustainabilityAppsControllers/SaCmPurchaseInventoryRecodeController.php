<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaCmPurchaseInventoryRecord\PurchaseInventoryRecordRequest;
use App\Repositories\All\SaCmPirCertificateRecord\CertificateRecordInterface;
use App\Repositories\All\SaCmPurchaseInventory\PurchaseInventoryInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\ChemicalManagementService;
use App\Services\PirCertificationRecodeService;

class SaCmPurchaseInventoryRecodeController extends Controller
{

    protected $purchaseInventoryInterface;
    protected $userInterface;
    protected $chemicalManagementService;
    protected $certificationRecodeService;
    protected $certificateRecordInterface;

    public function __construct(PurchaseInventoryInterface $purchaseInventoryInterface, ChemicalManagementService $chemicalManagementService, PirCertificationRecodeService $certificationRecodeService, UserInterface $userInterface, CertificateRecordInterface $certificateRecordInterface)
    {
        $this->purchaseInventoryInterface = $purchaseInventoryInterface;
        $this->userInterface              = $userInterface;
        $this->chemicalManagementService  = $chemicalManagementService;
        $this->certificationRecodeService = $certificationRecodeService;
        $this->certificateRecordInterface = $certificateRecordInterface;

    }
    public function index()
    {
        $records = $this->purchaseInventoryInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        foreach ($records as &$record) {
            $documents = [];
            if (! empty($record->documents) && is_string($record->documents)) {
                $documents = json_decode($record->documents, true);
            } elseif (is_array($record->documents)) {
                $documents = $record->documents;
            }

            foreach ($documents as &$doc) {
                if (isset($doc['gsutil_uri'])) {
                    $urlData         = $this->chemicalManagementService->getImageUrl($doc['gsutil_uri']);
                    $doc['imageUrl'] = $urlData['signedUrl'];
                    $doc['fileName'] = $urlData['fileName'];
                }
            }
            $record->documents = $documents;

            $certificate = $this->certificateRecordInterface->findByInventoryId($record->id);

            foreach ($certificate as &$certificate) {
                $certificateDocs = [];

                if (! empty($certificate->documents) && is_string($certificate->documents)) {
                    $certificateDocs = json_decode($certificate->documents, true);
                } elseif (is_array($certificate->documents)) {
                    $certificateDocs = $certificate->documents;
                }

                foreach ($certificateDocs as &$doc) {
                    if (isset($doc['gsutil_uri'])) {
                        $urlData         = $this->certificationRecodeService->getImageUrl($doc['gsutil_uri']);
                        $doc['imageUrl'] = $urlData['signedUrl'];
                        $doc['fileName'] = $urlData['fileName'];
                    }
                }

                $certificate->documents = $certificateDocs;
            }

            $record->certificate = $certificate;
        }

        return response()->json($records, 200);
    }

    public function publishStatus($id, PurchaseInventoryRecordRequest $request)
    {
        $validatedData           = $request->validated();
        $validatedData['status'] = 'published';

        $targetSetting = $this->purchaseInventoryInterface->findById($id);

        $documents = json_decode($targetSetting->documents, true) ?? [];

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->chemicalManagementService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($doc) use ($removeDocs) {
                    return ! in_array($doc['gsutil_uri'], $removeDocs);
                }));
            }
        }

        if ($request->hasFile('documents')) {
            $newDocuments = [];
            $existingUris = array_column($documents, 'gsutil_uri');

            foreach ($request->file('documents') as $newFile) {
                $uploadResult = $this->chemicalManagementService->updateDocuments($newFile);

                if (
                    $uploadResult &&
                    isset($uploadResult['gsutil_uri']) &&
                    ! in_array($uploadResult['gsutil_uri'], $existingUris)
                ) {
                    $gsutilUri = $uploadResult['gsutil_uri'];

                    $newDocuments[] = [
                        'gsutil_uri' => $gsutilUri,
                        'file_name'  => $uploadResult['file_name'] ?? basename($gsutilUri ?? $newFile->getClientOriginalName()),
                    ];

                    $existingUris[] = $gsutilUri; 
                }
            }

            $documents = array_merge($documents, $newDocuments);
        }

        $validatedData['documents'] = json_encode($documents);

        $updatedRecord = $this->purchaseInventoryInterface->update($id, $validatedData);

        if (! $updatedRecord) {
            return response()->json([
                'message' => 'Failed to publish purchase inventory record.',
            ], 500);
        }

        $updatedRecord = $this->purchaseInventoryInterface->findById($id);

        if (! empty($validatedData['certificate'])) {
            foreach ($validatedData['certificate'] as $index => $certificateData) {
                $certDocs = [];

                if ($request->hasFile("certificate.{$index}.documents")) {
                    foreach ($request->file("certificate.{$index}.documents") as $certFile) {
                        $uploadResult = $this->certificationRecodeService->uploadImageToGCS($certFile);
                        if ($uploadResult && isset($uploadResult['gsutil_uri'])) {
                            $certDocs[] = [
                                'gsutil_uri' => $uploadResult['gsutil_uri'],
                                'file_name'  => $uploadResult['file_name'] ?? basename($uploadResult['gsutil_uri'] ?? $certFile->getClientOriginalName()),
                            ];
                        }
                    }
                }

                $certificateData['inventoryId'] = $updatedRecord->id;
                $certificateData['documents']   = $certDocs;

                $this->certificateRecordInterface->create($certificateData);
            }
        }

        return response()->json([
            'message' => 'Purchase inventory record published successfully.',
            'data'    => $updatedRecord,
        ]);
    }

    public function update($id, PurchaseInventoryRecordRequest $request)
    {
        $validatedData = $request->validated();

        $targetSetting = $this->purchaseInventoryInterface->findById($id);
        $documents     = json_decode($targetSetting->documents, true) ?? [];

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');
            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->chemicalManagementService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($doc) use ($removeDocs) {
                    return ! in_array($doc['gsutil_uri'], $removeDocs);
                }));
            }
        }

        if ($request->hasFile('documents')) {
            $newDocuments = [];
            foreach ($request->file('documents') as $newFile) {
                $uploadResult = $this->chemicalManagementService->updateDocuments($newFile);
                if ($uploadResult && isset($uploadResult['gsutil_uri'])) {
                    $newDocuments[] = [
                        'gsutil_uri' => $uploadResult['gsutil_uri'],
                        'file_name'  => $uploadResult['file_name'],
                    ];
                }
            }
            $documents = array_merge($documents, $newDocuments);
        }

        $validatedData['documents'] = json_encode($documents);

        $updatedRecord = $this->purchaseInventoryInterface->update($id, $validatedData);
        if (! $updatedRecord) {
            return response()->json([
                'message' => 'Failed to update purchase inventory record.',
            ], 500);
        }

        $updatedRecord = $this->purchaseInventoryInterface->findById($id);

        if (! empty($validatedData['certificate'])) {
            foreach ($validatedData['certificate'] as $index => $certificateData) {
                $certDocs = [];

                if (! empty($certificateData['removeDoc'])) {
                    $removeCertDocs = is_array($certificateData['removeDoc']) ? $certificateData['removeDoc'] : [$certificateData['removeDoc']];
                    foreach ($removeCertDocs as $removeDoc) {
                        $this->certificationRecodeService->removeOldDocumentFromStorage($removeDoc);
                    }
                }

                if ($request->hasFile("certificate.{$index}.documents")) {
                    foreach ($request->file("certificate.{$index}.documents") as $certFile) {
                        $uploadResult = $this->certificationRecodeService->uploadImageToGCS($certFile);
                        if ($uploadResult && isset($uploadResult['gsutil_uri'])) {
                            $certDocs[] = [
                                'gsutil_uri' => $uploadResult['gsutil_uri'],
                                'file_name'  => $uploadResult['file_name'],
                            ];
                        }
                    }
                }

                $certificateData['inventoryId'] = $updatedRecord->id;
                $certificateData['documents']   = $certDocs;

                if (! empty($certificateData['inventoryId'])) {
                    $this->certificateRecordInterface->updateOrCreate(
                        ['inventoryId' => $updatedRecord->id, 'testName' => $certificateData['testName']],
                        $certificateData
                    );
                } else {
                    $this->certificateRecordInterface->create($certificateData);
                }
            }
        }

        return response()->json([
            'message' => 'Purchase inventory record updated successfully.',
            'data'    => $updatedRecord,
        ]);
    }

    public function destroy($id)
    {
        $record = $this->purchaseInventoryInterface->findById($id);

        if (! $record) {
            return response()->json([
                'message' => 'Purchase inventory record not found.',
            ], 404);
        }

        $documents = json_decode($record->documents, true) ?? [];
        foreach ($documents as $doc) {
            if (isset($doc['gsutil_uri'])) {
                $this->chemicalManagementService->removeOldDocumentFromStorage($doc['gsutil_uri']);
            }
        }

        $certificates = $this->certificateRecordInterface->findByInventoryId($id);
        foreach ($certificates as $certificate) {
            $certDocs = json_decode($certificate->documents, true) ?? [];
            foreach ($certDocs as $doc) {
                if (isset($doc['gsutil_uri'])) {
                    $this->certificationRecodeService->removeOldDocumentFromStorage($doc['gsutil_uri']);
                }
            }

            $this->certificateRecordInterface->deleteById($certificate->id);
        }

        $deleted = $this->purchaseInventoryInterface->deleteById($id);

        if (! $deleted) {
            return response()->json([
                'message' => 'Failed to delete purchase inventory record.',
            ], 500);
        }

        return response()->json([
            'message' => 'Purchase inventory record deleted successfully.',
        ], 200);
    }

}
