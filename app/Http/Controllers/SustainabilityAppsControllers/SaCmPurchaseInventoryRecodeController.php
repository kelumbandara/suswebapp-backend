<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaCmPurchaseInventoryRecord\PurchaseInventoryRecordRequest;
use App\Repositories\All\SaCmChemicalManagementRecode\ChemicalManagementRecodeInterface;
use App\Repositories\All\SaCmPirCertificateRecord\CertificateRecordInterface;
use App\Repositories\All\SaCmPurchaseInventory\PurchaseInventoryInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\ChemicalManagementService;
use App\Services\PirCertificationRecodeService;
use Illuminate\Support\Facades\Auth;

class SaCmPurchaseInventoryRecodeController extends Controller
{

    protected $purchaseInventoryInterface;
    protected $userInterface;
    protected $chemicalManagementService;
    protected $certificationRecodeService;
    protected $certificateRecordInterface;
    protected $chemicalManagementRecodeInterface;

    public function __construct(PurchaseInventoryInterface $purchaseInventoryInterface, ChemicalManagementRecodeInterface $chemicalManagementRecodeInterface, ChemicalManagementService $chemicalManagementService, PirCertificationRecodeService $certificationRecodeService, UserInterface $userInterface, CertificateRecordInterface $certificateRecordInterface)
    {
        $this->purchaseInventoryInterface        = $purchaseInventoryInterface;
        $this->userInterface                     = $userInterface;
        $this->chemicalManagementService         = $chemicalManagementService;
        $this->certificationRecodeService        = $certificationRecodeService;
        $this->certificateRecordInterface        = $certificateRecordInterface;
        $this->chemicalManagementRecodeInterface = $chemicalManagementRecodeInterface;

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

            $certificates = $this->certificateRecordInterface->findByInventoryId($record->id);

            $certificates = is_array($certificates) ? $certificates : collect($certificates)->all();

            foreach ($certificates as &$certificate) {
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

            $record->certificate = $certificates;

            try {
                $creator               = $this->userInterface->getById($record->createdByUser);
                $record->createdByUser = $creator ? ['name' => $creator->name, 'id' => $creator->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->createdByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $updater               = $this->userInterface->getById($record->updatedBy);
                $record->updatedByUser = $updater ? ['name' => $updater->name, 'id' => $updater->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->updatedByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $approver               = $this->userInterface->getById($record->approverId);
                $record->approvedByUser = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->approvedByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $publisher               = $this->userInterface->getById($record->publishedBy);
                $record->publishedByUser = $publisher ? ['name' => $publisher->name, 'id' => $publisher->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->publishedByUser = ['name' => 'Unknown', 'id' => null];
            }

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

                if ($uploadResult && isset($uploadResult['gsutil_uri'])) {
                    $gsutilUri = $uploadResult['gsutil_uri'];

                    if (! in_array($gsutilUri, $existingUris)) {
                        $newDocuments[] = [
                            'gsutil_uri' => $gsutilUri,
                            'file_name'  => $uploadResult['file_name'] ?? basename($gsutilUri),
                        ];
                        $existingUris[] = $gsutilUri;
                    }
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
                                'file_name'  => $uploadResult['file_name'] ?? basename($uploadResult['gsutil_uri']),
                            ];
                        }
                    }
                }

                $certificateData['inventoryId'] = $updatedRecord->id;
                $certificateData['documents']   = json_encode($certDocs);

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

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $records = $this->purchaseInventoryInterface
            ->getByReviewerId($user->id)
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

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

            $record->certificate = [$certificate] ? $certificate : null;

            try {
                $creator               = $this->userInterface->getById($record->createdByUser);
                $record->createdByUser = $creator ? ['name' => $creator->name, 'id' => $creator->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->createdByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $updater               = $this->userInterface->getById($record->updatedBy);
                $record->updatedByUser = $updater ? ['name' => $updater->name, 'id' => $updater->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->updatedByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $approver               = $this->userInterface->getById($record->approverId);
                $record->approvedByUser = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->approvedByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $publisher               = $this->userInterface->getById($record->publishedBy);
                $record->publishedByUser = $publisher ? ['name' => $publisher->name, 'id' => $publisher->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->publishedByUser = ['name' => 'Unknown', 'id' => null];
            }
        }

        return response()->json($records, 200);
    }

    public function getPublishedStatus()
    {
        $records = $this->purchaseInventoryInterface->All()
            ->where('status', 'published')
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

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

            $record->certificate = $certificate ? [$certificate] : [];
            try {
                $creator               = $this->userInterface->getById($record->createdByUser);
                $record->createdByUser = $creator ? ['name' => $creator->name, 'id' => $creator->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->createdByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $updater               = $this->userInterface->getById($record->updatedBy);
                $record->updatedByUser = $updater ? ['name' => $updater->name, 'id' => $updater->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->updatedByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $approver               = $this->userInterface->getById($record->approverId);
                $record->approvedByUser = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->approvedByUser = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $publisher               = $this->userInterface->getById($record->publishedBy);
                $record->publishedByUser = $publisher ? ['name' => $publisher->name, 'id' => $publisher->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $record->publishedByUser = ['name' => 'Unknown', 'id' => null];
            }
        }

        return response()->json($records, 200);
    }

    public function getStockAmount($startDate, $endDate, $division)
    {
        $records = $this->purchaseInventoryInterface->filterByParams($startDate, $endDate, $division);

        $inStockFormulas = [];
        $deliveredTotal  = 0;
        $amountTotal     = 0;

        foreach ($records as $record) {
            if ($record->status !== 'published') {
                continue;
            }

            if (! empty($record->molecularFormula)) {
                $inStockFormulas[$record->molecularFormula] = true;
            }

            if (is_numeric($record->deliveryQuantity)) {
                $deliveredTotal += floatval($record->deliveryQuantity);
            }

            if (is_numeric($record->purchaseAmount)) {
                $amountTotal += floatval($record->purchaseAmount);
            }
        }

        return response()->json([
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'division'       => $division,
            'inStockCount'   => count($inStockFormulas),
            'deliveredTotal' => $deliveredTotal,
            'purchaseAmount' => round($amountTotal, 2),
        ]);
    }

    public function getMonthlyDelivery($startDate, $endDate, $division)
    {
        $records = $this->purchaseInventoryInterface->filterByParams($startDate, $endDate, $division);

        $aggregated = [];

        foreach ($records as $record) {
            if ($record->status !== 'published') {
                continue;
            }

            if (empty($record->deliveryDate) || empty($record->molecularFormula)) {
                continue;
            }

            $deliveryDate = \Carbon\Carbon::parse($record->deliveryDate);

            if ($deliveryDate->lt($startDate) || $deliveryDate->gt($endDate)) {
                continue;
            }

            $monthName = $deliveryDate->format('F');
            $formula   = $record->molecularFormula;
            $quantity  = is_numeric($record->deliveryQuantity) ? floatval($record->deliveryQuantity) : 0;

            if (! isset($aggregated[$monthName][$formula])) {
                $aggregated[$monthName][$formula] = 0;
            }

            $aggregated[$monthName][$formula] += $quantity;
        }

        $monthlyBreakdown = [];

        foreach ($aggregated as $month => $formulas) {
            foreach ($formulas as $formula => $quantity) {
                $monthlyBreakdown[] = [
                    'month'    => $month,
                    'chemical' => $formula,
                    'quantity' => $quantity,
                ];
            }
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'data'      => $monthlyBreakdown,
        ]);
    }

    public function getLatestRecord($startDate, $endDate, $division)
    {
        $records = $this->purchaseInventoryInterface
            ->filterByParams($startDate, $endDate, $division)
            ->sortByDesc('updated_at');

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        foreach ($records as $record) {
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

            $certificates = $this->certificateRecordInterface->findByInventoryId($record->id);
            $certificates = is_array($certificates) ? $certificates : collect($certificates)->all();

            foreach ($certificates as &$certificate) {
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

            $record->certificate = $certificates;

            $record->createdByUser   = $this->getUserInfo($record->createdByUser);
            $record->updatedByUser   = $this->getUserInfo($record->updatedBy);
            $record->approvedByUser  = $this->getUserInfo($record->approverId);
            $record->publishedByUser = $this->getUserInfo($record->publishedBy);
        }

        return response()->json(array_values($records->toArray()));

    }

    public function getTransactionLatestRecord($startDate, $endDate, $division)
    {
        $records = $this->purchaseInventoryInterface
            ->filterByParams($startDate, $endDate, $division)
            ->where('status', 'published')
            ->sortByDesc('updated_at');

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No published records found'], 404);
        }

        foreach ($records as $record) {
            $documents = is_string($record->documents) ? json_decode($record->documents, true) : ($record->documents ?? []);
            foreach ($documents as &$doc) {
                if (isset($doc['gsutil_uri'])) {
                    $urlData         = $this->chemicalManagementService->getImageUrl($doc['gsutil_uri']);
                    $doc['imageUrl'] = $urlData['signedUrl'];
                    $doc['fileName'] = $urlData['fileName'];
                }
            }
            $record->documents = $documents;

            $certificates = collect($this->certificateRecordInterface->findByInventoryId($record->id));
            foreach ($certificates as &$certificate) {
                $certificateDocs = is_string($certificate->documents) ? json_decode($certificate->documents, true) : ($certificate->documents ?? []);
                foreach ($certificateDocs as &$doc) {
                    if (isset($doc['gsutil_uri'])) {
                        $urlData         = $this->certificationRecodeService->getImageUrl($doc['gsutil_uri']);
                        $doc['imageUrl'] = $urlData['signedUrl'];
                        $doc['fileName'] = $urlData['fileName'];
                    }
                }
                $certificate->documents = $certificateDocs;
            }

            $record->certificate     = $certificates;
            $record->createdByUser   = $this->getUserInfo($record->createdByUser);
            $record->updatedByUser   = $this->getUserInfo($record->updatedBy);
            $record->approvedByUser  = $this->getUserInfo($record->approverId);
            $record->publishedByUser = $this->getUserInfo($record->publishedBy);

            $response[] = $record;
        }

        return response()->json($response);
    }

    private function getUserInfo($userId)
    {
        try {
            $user = $this->userInterface->getById($userId);
            return $user ? ['name' => $user->name, 'id' => $user->id] : ['name' => 'Unknown', 'id' => null];
        } catch (\Exception $e) {
            return ['name' => 'Unknown', 'id' => null];
        }
    }

    public function getStockThreshold($startDate, $endDate, $division)
    {
        $records = $this->purchaseInventoryInterface->filterByParams($startDate, $endDate, $division);

        $chemicals = [];

        foreach ($records as $record) {
            if ($record->status !== 'published') {
                continue;
            }

            if (empty($record->molecularFormula) || ! is_numeric($record->deliveryQuantity) || ! is_numeric($record->thresholdLimit)) {
                continue;
            }

            $formula        = $record->molecularFormula;
            $deliveryQty    = floatval($record->deliveryQuantity);
            $thresholdLimit = floatval($record->thresholdLimit);

            if (! isset($chemicals[$formula])) {
                $chemicals[$formula] = [
                    'chemicalName'  => $formula,
                    'totalLimit'    => 0,
                    'totalQuantity' => 0,
                ];
            }

            $chemicals[$formula]['totalLimit'] += $thresholdLimit;
            $chemicals[$formula]['totalQuantity'] += $deliveryQty;
        }

        foreach ($chemicals as &$data) {
            if ($data['totalLimit'] > 0) {
                $data['percentage'] = round(($data['totalQuantity'] / $data['totalLimit']) * 100, 2);
            } else {
                $data['percentage'] = 0;
            }
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'data'      => array_values($chemicals),
        ]);
    }

    public function getHighestStock($startDate, $endDate, $division)
    {
        $records = $this->purchaseInventoryInterface->filterByParams($startDate, $endDate, $division);

        $chemicals = [];

        foreach ($records as $record) {
            if ($record->status !== 'published') {
                continue;
            }

            if (empty($record->molecularFormula) || ! is_numeric($record->deliveryQuantity)) {
                continue;
            }

            $formula     = $record->molecularFormula;
            $deliveryQty = floatval($record->deliveryQuantity);

            if (! isset($chemicals[$formula])) {
                $chemicals[$formula] = [
                    'chemicalName'  => $formula,
                    'totalQuantity' => 0,
                ];
            }

            $chemicals[$formula]['totalQuantity'] += $deliveryQty;
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'data'      => array_values($chemicals),
        ]);
    }

    public function getStatusSummary($startDate, $endDate, $division)
    {
        $statusCounts = [];

        $purchaseRecords = $this->purchaseInventoryInterface->filterByParams($startDate, $endDate, $division);
        foreach ($purchaseRecords as $record) {
            $status = $record->status ?? 'unknown';
            if (! isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
            $statusCounts[$status]++;
        }

        $chemicalRecords = $this->chemicalManagementRecodeInterface->filterByParams($startDate, $endDate, $division);
        foreach ($chemicalRecords as $record) {
            $status = $record->status ?? 'unknown';
            if (! isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
            $statusCounts[$status]++;
        }

        $summary = [];
        foreach ($statusCounts as $status => $count) {
            $summary[] = [
                'status' => $status,
                'count'  => $count,
            ];
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'data'      => $summary,
        ]);
    }

public function getAllSummary($year)
{
    $startDate = \Carbon\Carbon::parse("$year-01-01");
    $endDate   = \Carbon\Carbon::parse("$year-12-31");

    $purchaseRecords = $this->purchaseInventoryInterface->filterByYear($year);
    $chemicalRecords = $this->chemicalManagementRecodeInterface->filterByYear($year);

    $inStockFormulas       = [];
    $deliveredTotal        = 0;
    $amountTotal           = 0;
    $monthlyAggregated     = [];
    $thresholdChemicals    = [];
    $highestStockChemicals = [];
    $statusCounts          = [];

    $latestPublishedRecord = null;
    $latestPublishedTime   = null;
    $latestRecord          = null;
    $latestRecordTime      = null;

    foreach ($purchaseRecords as $record) {
        if (!empty($record->molecularFormula)) {
            $inStockFormulas[$record->molecularFormula] = true;
        }

        if (!$latestRecordTime || $record->updated_at > $latestRecordTime) {
            $latestRecord     = clone $record;
            $latestRecordTime = $record->updated_at;
        }

        if ($record->status === 'published') {
            if (is_numeric($record->deliveryQuantity)) {
                $qty = floatval($record->deliveryQuantity);
                $deliveredTotal += $qty;

                if (is_numeric($record->thresholdLimit)) {
                    $formula   = $record->molecularFormula;
                    $threshold = floatval($record->thresholdLimit);
                    if (!isset($thresholdChemicals[$formula])) {
                        $thresholdChemicals[$formula] = ['chemicalName' => $formula, 'totalLimit' => 0, 'totalQuantity' => 0];
                    }
                    $thresholdChemicals[$formula]['totalLimit'] += $threshold;
                    $thresholdChemicals[$formula]['totalQuantity'] += $qty;
                }

                if (!isset($highestStockChemicals[$formula])) {
                    $highestStockChemicals[$formula] = ['chemicalName' => $formula, 'totalQuantity' => 0];
                }
                $highestStockChemicals[$formula]['totalQuantity'] += $qty;
            }

            if (is_numeric($record->purchaseAmount)) {
                $amountTotal += floatval($record->purchaseAmount);
            }

            if (!empty($record->deliveryDate) && !empty($record->molecularFormula)) {
                $deliveryDate = \Carbon\Carbon::parse($record->deliveryDate);
                if ($deliveryDate->between($startDate, $endDate)) {
                    $monthName = $deliveryDate->format('F');
                    $formula   = $record->molecularFormula;
                    $qty       = is_numeric($record->deliveryQuantity) ? floatval($record->deliveryQuantity) : 0;

                    if (!isset($monthlyAggregated[$monthName][$formula])) {
                        $monthlyAggregated[$monthName][$formula] = 0;
                    }
                    $monthlyAggregated[$monthName][$formula] += $qty;
                }
            }

            if (!$latestPublishedTime || $record->updated_at > $latestPublishedTime) {
                $latestPublishedRecord = $record;
                $latestPublishedTime   = $record->updated_at;
            }
        }

        $status = $record->status ?? 'unknown';
        if (!isset($statusCounts[$status])) {
            $statusCounts[$status] = 0;
        }
        $statusCounts[$status]++;
    }

    foreach ($chemicalRecords as $record) {
        $status = $record->status ?? 'unknown';
        if (!isset($statusCounts[$status])) {
            $statusCounts[$status] = 0;
        }
        $statusCounts[$status]++;
    }

    foreach ($thresholdChemicals as &$data) {
        $data['percentage'] = $data['totalLimit'] > 0
            ? round(($data['totalQuantity'] / $data['totalLimit']) * 100, 2)
            : 0;
    }

    $monthlyBreakdown = [];
    foreach ($monthlyAggregated as $month => $formulas) {
        foreach ($formulas as $formula => $qty) {
            $monthlyBreakdown[] = [
                'month'    => $month,
                'chemical' => $formula,
                'quantity' => $qty,
            ];
        }
    }

    $statusSummary = [];
    foreach ($statusCounts as $status => $count) {
        $statusSummary[] = ['status' => $status, 'count' => $count];
    }

    $formattedLatest = null;
    if ($latestPublishedRecord) {
        $formattedLatest = $latestPublishedRecord;
        $documents = is_string($formattedLatest->documents) ? json_decode($formattedLatest->documents, true) : ($formattedLatest->documents ?? []);
        foreach ($documents as &$doc) {
            if (isset($doc['gsutil_uri'])) {
                $urlData         = $this->chemicalManagementService->getImageUrl($doc['gsutil_uri']);
                $doc['imageUrl'] = $urlData['signedUrl'];
                $doc['fileName'] = $urlData['fileName'];
            }
        }
        $formattedLatest->documents   = $documents;
        $formattedLatest->certificate = collect($this->certificateRecordInterface->findByInventoryId($formattedLatest->id))->map(function ($cert) {
            $docs = is_string($cert->documents) ? json_decode($cert->documents, true) : ($cert->documents ?? []);
            foreach ($docs as &$doc) {
                if (isset($doc['gsutil_uri'])) {
                    $urlData         = $this->certificationRecodeService->getImageUrl($doc['gsutil_uri']);
                    $doc['imageUrl'] = $urlData['signedUrl'];
                    $doc['fileName'] = $urlData['fileName'];
                }
            }
            $cert->documents = $docs;
            return $cert;
        });
        $formattedLatest->createdByUser   = $this->getUserInfo($formattedLatest->createdByUser);
        $formattedLatest->updatedByUser   = $this->getUserInfo($formattedLatest->updatedBy);
        $formattedLatest->approvedByUser  = $this->getUserInfo($formattedLatest->approverId);
        $formattedLatest->publishedByUser = $this->getUserInfo($formattedLatest->publishedBy);
    }

    return response()->json([
        'year'              => $year,
        'inStockCount'      => count($inStockFormulas),
        'deliveredTotal'    => $deliveredTotal,
        'purchaseAmount'    => round($amountTotal, 2),
        'monthlyDelivery'   => $monthlyBreakdown,
        'stockThreshold'    => array_values($thresholdChemicals),
        'highestStock'      => array_values($highestStockChemicals),
        'statusSummary'     => $statusSummary,
        'latestRecord'      => $latestRecord,
        'latestTransaction' => $formattedLatest,
    ]);
}

}
