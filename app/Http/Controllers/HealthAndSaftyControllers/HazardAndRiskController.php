<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HazardAndRisk\HazardAndRiskRequest;
use App\Repositories\All\HazardAndRisk\HazardAndRiskInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\HazardRiskService;
use Illuminate\Support\Facades\Auth;

class HazardAndRiskController extends Controller
{

    protected $hazardAndRiskInterface;
    protected $userInterface;
    protected $hazardAndRiskService;

    public function __construct(HazardAndRiskInterface $hazardAndRiskInterface, UserInterface $userInterface, HazardRiskService $hazardAndRiskService)
    {
        $this->hazardAndRiskInterface = $hazardAndRiskInterface;
        $this->userInterface          = $userInterface;
        $this->hazardAndRiskService   = $hazardAndRiskService;
    }
    public function index()
    {
        $hazardRisks = $this->hazardAndRiskInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $hazardRisks = $hazardRisks->map(function ($risk) {
            try {
                $assignee       = $this->userInterface->getById($risk->assigneeId);
                $risk->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->assignee = ['name' => 'Unknown', 'id' => null];
            }
            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }

            if (! empty($risk->documents) && is_string($risk->documents)) {
                $documents = json_decode($risk->documents, true);
            } else {
                $documents = is_array($risk->documents) ? $risk->documents : [];
            }

            foreach ($documents as &$document) {
                if (isset($document['gsutil_uri'])) {
                    $imageData            = $this->hazardAndRiskService->getImageUrl($document['gsutil_uri']);
                    $document['imageUrl'] = $imageData['signedUrl'];
                    $document['fileName'] = $imageData['fileName'];
                }
            }

            $risk->documents = $documents;
            return $risk;
        });

        return response()->json($hazardRisks, 200);
    }

    public function store(HazardAndRiskRequest $request)
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
                $uploadedFiles[] = $this->hazardAndRiskService->uploadImageToGCS($file);
            }

            $validatedData['documents'] = json_encode($uploadedFiles);
        }

        $hazardRisk = $this->hazardAndRiskInterface->create($validatedData);

        return response()->json([
            'message'    => 'Hazard and risk record created successfully!',
            'hazardRisk' => $hazardRisk,
        ], 201);
    }

    public function show($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (! $hazardRisk) {
            return response()->json([
                'message' => 'Hazard and risk record not found.',
            ]);
        }

        return response()->json($hazardRisk, 200);
    }

    public function update($id, HazardAndRiskRequest $request)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById($id);

        if (!$hazardRisk) {
            return response()->json(['message' => 'Hazard and risk record not found.'], 404);
        }

        $validatedData = $request->validated();

        $documents = json_decode($hazardRisk->documents, true) ?? [];

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->hazardAndRiskService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($doc) use ($removeDocs) {
                    return !in_array($doc['gsutil_uri'], $removeDocs);
                }));
            }
        }

        if ($request->hasFile('documents')) {
            $newDocuments = [];
            foreach ($request->file('documents') as $newFile) {
                $uploadResult = $this->hazardAndRiskService->updateDocuments($newFile);

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

        $updated = $this->hazardAndRiskInterface->update($id, $validatedData);

        if ($updated) {
            return response()->json([
                'message'    => 'Hazard and risk record updated successfully!',
                'hazardRisk' => $this->hazardAndRiskInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the hazard and risk record.'], 500);
        }
    }


    public function destroy($id)
    {
        $hazardRisk = $this->hazardAndRiskInterface->findById((int) $id);

        if (! empty($hazardRisk->documents)) {
            if (is_string($hazardRisk->documents)) {
                $documents = json_decode($hazardRisk->documents, true);
            } else {
                $documents = $hazardRisk->documents;
            }

            if (is_array($documents)) {
                foreach ($documents as $document) {
                    $this->hazardAndRiskService->deleteImageFromGCS($document);
                }
            }
        }

        $deleted = $this->hazardAndRiskInterface->deleteById($id);

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

        $hazardRisks = $this->hazardAndRiskInterface->getByAssigneeId($user->id)->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $hazardRisks = $hazardRisks->map(function ($risk) {
            try {
                $assignee       = $this->userInterface->getById($risk->assigneeId);
                $risk->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->assignee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $risk->createdByUserName = 'Unknown';
            }
            if (! empty($risk->documents) && is_string($risk->documents)) {
                $documents = json_decode($risk->documents, true);
            } else {
                $documents = is_array($risk->documents) ? $risk->documents : [];
            }

            foreach ($documents as &$document) {
                if (isset($document['gsutil_uri'])) {
                    $imageData            = $this->hazardAndRiskService->getImageUrl($document['gsutil_uri']);
                    $document['imageUrl'] = $imageData['signedUrl'];
                    $document['fileName'] = $imageData['fileName'];
                }
            }

            $risk->documents = $documents;
            return $risk;
        });

        return response()->json($hazardRisks, 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Hazard And Risk Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }

    public function dashboardStats()
    {
        try {
            $total     = $this->hazardAndRiskInterface->countAll();
            $completed = $this->hazardAndRiskInterface->countByStatus('Completed');
            $pending   = $this->hazardAndRiskInterface->countByStatus('Pending');
            $amount    = $this->hazardAndRiskInterface->sumField('amount');

            return response()->json([
                'total'     => $total,
                'completed' => $completed,
                'pending'   => $pending,
                'amount'    => $amount,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching dashboard stats.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function dashboardStatsByDivision()
    {
        try {
            $divisions = $this->hazardAndRiskInterface->getDistinctDivisions();

            $divisionStats = [];

            foreach ($divisions as $division) {
                $totalCount = $this->hazardAndRiskInterface->countByDivision($division->division);

                $divisionStats[] = [
                    'division' => $division->division,
                    'total'    => $totalCount,
                ];
            }

            return response()->json($divisionStats, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching division-wise stats.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
