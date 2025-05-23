<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiExternalAudit\ExternalAuditRequest;
use App\Repositories\All\SaAiExternalAudit\ExternalAuditInterface;
use App\Repositories\All\SaAiInternalAuditRecode\InternalAuditRecodeInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\ExternalAuditService;
use Illuminate\Support\Facades\Auth;

class SaAiExternalAuditRecodeController extends Controller
{

    protected $externalAuditInterface;
    protected $userInterface;
    protected $externalAuditService;
    protected $internalAuditRecodeInterface;

    public function __construct(ExternalAuditInterface $externalAuditInterface, UserInterface $userInterface, ExternalAuditService $externalAuditService, InternalAuditRecodeInterface $internalAuditRecodeInterface)
    {
        $this->externalAuditInterface       = $externalAuditInterface;
        $this->userInterface                = $userInterface;
        $this->externalAuditService         = $externalAuditService;
        $this->internalAuditRecodeInterface = $internalAuditRecodeInterface;
    }

    public function index()
    {
        $externalAudit = $this->externalAuditInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $externalAudit = $externalAudit->map(function ($audit) {
            try {
                $approver        = $this->userInterface->getById($audit->approverId);
                $audit->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->approver = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $representor        = $this->userInterface->getById($audit->representorId);
                $audit->representor = $representor ? ['name' => $representor->name, 'id' => $representor->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->representor = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $creator                  = $this->userInterface->getById($audit->createdByUser);
                $audit->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $audit->createdByUserName = 'Unknown';
            }

            if (! empty($audit->documents) && is_string($audit->documents)) {
                $documents = json_decode($audit->documents, true);
            } else {
                $documents = is_array($audit->documents) ? $audit->documents : [];
            }

            foreach ($documents as &$document) {
                if (isset($document['gsutil_uri'])) {
                    $imageData            = $this->externalAuditService->getImageUrl($document['gsutil_uri']);
                    $document['imageUrl'] = $imageData['signedUrl'];
                    $document['fileName'] = $imageData['fileName'];
                }
            }

            $audit->documents = $documents;
            return $audit;
        });

        return response()->json($externalAudit, 200);
    }

    public function store(ExternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;

        if ($request->hasFile('documents')) {
            $uploadedFiles = [];

            foreach ($request->file('documents') as $file) {
                $uploadedFiles[] = $this->externalAuditService->uploadImageToGCS($file);
            }

            $validatedData['documents'] = json_encode($uploadedFiles);
        }

        $externalAudit = $this->externalAuditInterface->create($validatedData);

        if (! $externalAudit) {
            return response()->json(['message' => 'Failed to create external audit record'], 500);
        }
        return response()->json([
            'message'       => 'External audit record created successfully!',
            'externalAudit' => $externalAudit,
        ], 201);
    }

    public function update($id, ExternalAuditRequest $request)
    {
        $externalAudit = $this->externalAuditInterface->findById($id);

        if (! $externalAudit) {
            return response()->json(['message' => 'External audit record not found.'], 404);
        }

        $validatedData = $request->validated();
        $documents     = json_decode($externalAudit->documents, true) ?? [];

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->externalAuditService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($doc) use ($removeDocs) {
                    return isset($doc['gsutil_uri']) && ! in_array($doc['gsutil_uri'], $removeDocs);
                }));

                $externalAudit->update(['documents' => json_encode($documents)]);
            }
        }

        if ($request->hasFile('documents')) {
            $newDocuments = [];

            foreach ($request->file('documents') as $newFile) {
                $uploadResult = $this->externalAuditService->updateDocuments($newFile);

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
        $updated                    = $externalAudit->update($validatedData);

        if ($updated) {
            return response()->json([
                'message'       => 'External audit record updated successfully!',
                'externalAudit' => $this->externalAuditInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the external audit record.'], 500);
        }
    }

    public function destroy($id)
    {
        $externalAudit = $this->externalAuditInterface->findById((int) $id);

        if (! empty($externalAudit->documents)) {
            if (is_string($externalAudit->documents)) {
                $documents = json_decode($externalAudit->documents, true);
            } else {
                $documents = $externalAudit->documents;
            }

            if (is_array($documents)) {
                foreach ($documents as $document) {
                    $this->externalAuditService->deleteImageFromGCS($document);
                }
            }
        }

        $deleted = $this->externalAuditInterface->deleteById($id);

        return response()->json([
            'message' => $deleted ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $deleted ? 200 : 500);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $externalAudit = $this->externalAuditInterface->getByApproverId($user->id)->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $externalAudit = $externalAudit->map(function ($audit) {
            try {
                $approver        = $this->userInterface->getById($audit->approverId);
                $audit->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $representor        = $this->userInterface->getById($audit->representorId);
                $audit->representor = $representor ? ['name' => $representor->name, 'id' => $representor->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->representor = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                  = $this->userInterface->getById($audit->createdByUser);
                $audit->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $audit->createdByUserName = 'Unknown';
            }
            if (! empty($audit->documents) && is_string($audit->documents)) {
                $documents = json_decode($audit->documents, true);
            } else {
                $documents = is_array($audit->documents) ? $audit->documents : [];
            }

            foreach ($documents as &$document) {
                if (isset($document['gsutil_uri'])) {
                    $imageData            = $this->externalAuditService->getImageUrl($document['gsutil_uri']);
                    $document['imageUrl'] = $imageData['signedUrl'];
                    $document['fileName'] = $imageData['fileName'];
                }
            }

            $audit->documents = $documents;
            return $audit;
        });

        return response()->json($externalAudit, 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'External Audit Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }


    public function getCombinedStatusCountByMonth($startDate = null, $endDate = null,  $division = null, $type = null)
    {


        $monthNumber = null;

        $statusSummary = [];
        $auditFeeTotal = 0;

        if ($type === 'external' || $type === 'both') {
            $externalRecords = $this->externalAuditInterface->filterByParams(
                $startDate, $endDate, $division
            );

            foreach ($externalRecords as $record) {
                $status                 = strtolower(trim($record->status ?? 'unknown'));
                $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;

                if (is_numeric($record->auditFee)) {
                    $auditFeeTotal += floatval($record->auditFee);
                }
            }
        }

        if ($type === 'internal' || $type === 'both') {
            $internalRecords = $this->internalAuditRecodeInterface->filterByParams(
                $startDate, $endDate, $division
            );

            foreach ($internalRecords as $record) {
                $status                 = strtolower(trim($record->status ?? 'unknown'));
                $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;

                if (is_numeric($record->auditFee)) {
                    $auditFeeTotal += floatval($record->auditFee);
                }
            }
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'type'      => $type,
            'data'      => [
                'status'        => $statusSummary,
                'auditFeeTotal' => round($auditFeeTotal, 2),
            ],
        ]);
    }

public function getStatusCountByMonth($startDate, $endDate, $year, $division, $type)
{
    $monthNames = [
        1 => 'January', 2 => 'February', 3 => 'March',
        4 => 'April', 5 => 'May', 6 => 'June',
        7 => 'July', 8 => 'August', 9 => 'September',
        10 => 'October', 11 => 'November', 12 => 'December',
    ];

    $monthlyStatusCounts = [];

    for ($month = 1; $month <= 12; $month++) {
        $statusSummary = [];

        if ($type === 'external' || $type === 'both') {
            $externalRecords = $this->externalAuditInterface
                ->filterByYearMonthDivision($year, $month, $division);

            foreach ($externalRecords as $record) {
                $status = strtolower(trim($record->status ?? 'unknown'));
                $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;
            }
        }

        if ($type === 'internal' || $type === 'both') {
            $internalRecords = $this->internalAuditRecodeInterface
                ->filterByYearMonthDivision($year, $month, $division);

            foreach ($internalRecords as $record) {
                $status = strtolower(trim($record->status ?? 'unknown'));
                $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;
            }
        }

        $monthlyStatusCounts[$monthNames[$month]] = $statusSummary;
    }

    return response()->json([
        'startDate' => $startDate,
        'endDate'   => $endDate,
        'year'      => (int) $year,
        'division'  => $division,
        'type'      => $type,
        'data'      => $monthlyStatusCounts,
    ]);
}

    public function getAuditScoresByYearDivision($year, $division)
    {
        $monthNames = [
            1  => 'January', 2  => 'February', 3  => 'March',
            4  => 'April', 5    => 'May', 6       => 'June',
            7  => 'July', 8     => 'August', 9    => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $monthlyAuditScores = array_combine(array_values($monthNames), array_fill(0, 12, []));

        for ($month = 1; $month <= 12; $month++) {
            $records = $this->externalAuditInterface->filterByYearMonthDivision($year, $month, $division);

            $statusSummary = [];

            foreach ($records as $record) {
                $category = $record->auditCategory;
                $score    = is_numeric($record->auditScore) ? floatval($record->auditScore) : 0;

                if (! isset($statusSummary[$category])) {
                    $statusSummary[$category] = 0;
                }

                $statusSummary[$category] += $score;
            }

            $monthName                      = $monthNames[$month];
            $monthlyAuditScores[$monthName] = $statusSummary;
        }

        return response()->json([
            'year'     => (int) $year,
            'division' => $division,
            'data'     => $monthlyAuditScores,
        ]);
    }

}
