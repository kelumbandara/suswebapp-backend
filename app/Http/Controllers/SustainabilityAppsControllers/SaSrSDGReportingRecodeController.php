<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrSDGReportRecode\SDGReportRecodeRequest;
use App\Repositories\All\SaSDGRecode\SDGRecodeInterface;
use App\Repositories\All\SaSrImpactDetails\ImpactDetailsInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\SDGService;
use Illuminate\Support\Facades\Auth;

class SaSrSDGReportingRecodeController extends Controller
{
    protected $sdgRecodeInterface;
    protected $impactDetailsInterface;
    protected $userInterface;
    protected $sdgService;

    public function __construct(SDGRecodeInterface $sdgRecodeInterface, ImpactDetailsInterface $impactDetailsInterface, UserInterface $userInterface, SDGService $sdgService)
    {
        $this->sdgRecodeInterface     = $sdgRecodeInterface;
        $this->impactDetailsInterface = $impactDetailsInterface;
        $this->userInterface          = $userInterface;
        $this->sdgService             = $sdgService;
    }

    public function index()
    {
        $records = $this->sdgRecodeInterface->All();
        $records = $records->map(function ($risk) {
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
                $decodedDocuments = json_decode($risk->documents, true);
                $documents        = is_array($decodedDocuments) ? $decodedDocuments : [];
            } else {
                $documents = is_array($risk->documents) ? $risk->documents : [];
            }

            foreach ($documents as &$item) {
                if (isset($item['gsutil_uri'])) {
                    $imageData        = $this->sdgService->getImageUrl($item['gsutil_uri']);
                    $item['fileName'] = $imageData['fileName'];
                    $item['imageUrl'] = $imageData['signedUrl'];
                }
            }

            $risk->documents = $documents;

            return $risk;
        });
        foreach ($records as $record) {
            $record->impactDetails = $this->impactDetailsInterface->findBySdgId($record->id);

        }

        return response()->json($records, 200);
    }

    public function store(SDGReportRecodeRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;

        $record = $this->sdgRecodeInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create SDG report'], 500);
        }

        $uploadedFiles = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $uploadedFiles[] = $this->sdgService->uploadImageToGCS($file);
            }
        }

        if (! empty($uploadedFiles)) {
            $decodedDocuments = (! empty($record->documents) && is_string($record->documents))
            ? json_decode($record->documents, true)
            : [];

            if (! is_array($decodedDocuments)) {
                $decodedDocuments = [];
            }

            $mergedDocuments = array_merge($decodedDocuments, $uploadedFiles);

            $this->sdgRecodeInterface->update($record->id, [
                'documents' => json_encode($mergedDocuments),
            ]);
        }

        if (! empty($data['impactDetails'])) {
            foreach ($data['impactDetails'] as $impactDetails) {
                $impactDetails['sdgId'] = $record->id;
                $this->impactDetailsInterface->create($impactDetails);
            }
        }

        return response()->json([
            'message' => 'SDG report created successfully',
            'record'  => $record,
        ], 201);
    }

    public function update(SDGReportRecodeRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->sdgRecodeInterface->findById($id);

        $documents = json_decode($record->documents, true) ?? [];

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->sdgService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($evidenceItem) use ($removeDocs) {
                    return ! in_array($evidenceItem['gsutil_uri'], $removeDocs);
                }));
            }
        }

        if ($request->hasFile('documents')) {
            $newEvidence = [];
            $newFiles    = $request->file('documents');

            foreach ($newFiles as $newFile) {
                $uploadResult = $this->sdgService->updateDocuments($newFile);
                if ($uploadResult && isset($uploadResult['gsutil_uri'])) {
                    $newEvidence[] = [
                        'gsutil_uri' => $uploadResult['gsutil_uri'],
                        'file_name'  => $uploadResult['file_name'],
                    ];
                }
            }

            $documents = array_merge($documents, $newEvidence);
        }

        $data['documents'] = json_encode($documents);

        $updateSuccess = $record->update($data);
        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update sdg report'], 500);
        }

        $this->impactDetailsInterface->deleteBySdgId($id);

        if (! empty($data['impactDetails'])) {
            foreach ($data['impactDetails'] as $impactDetails) {
                $impactDetails['sdgId'] = $id;
                $this->impactDetailsInterface->create($impactDetails);
            }
        }

        $updatedRecord                = $this->sdgRecodeInterface->findById($id);
        $updatedRecord->impactDetails = $this->impactDetailsInterface->findBySdgId($id);

        return response()->json([
            'message' => 'SDG report updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }
    
    public function destroy(string $id)
    {
        $record = $this->sdgRecodeInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }

        $this->impactDetailsInterface->deleteBySdgId($id);

        if ($record->documents) {
            $documents = json_decode($record->documents, true);

            if (is_array($documents)) {
                foreach ($documents as $item) {
                    if (isset($item['gsutil_uri'])) {
                        $this->sdgService->deleteImageFromGCS($item['gsutil_uri']);
                    }
                }
            }
        }

        $this->sdgRecodeInterface->deleteById($id);

        return response()->json(['message' => 'SDG report deleted successfully'], 200);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $record = $this->sdgRecodeInterface->getByAssigneeId($user->id);

        $record = $record->map(function ($impactDetails) {
            try {
                $assignee                = $this->userInterface->getById($impactDetails->assigneeId);
                $impactDetails->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $impactDetails->assignee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                          = $this->userInterface->getById($impactDetails->createdByUser);
                $impactDetails->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $impactDetails->createdByUserName = 'Unknown';
            }
            if (! empty($impactDetails->documents) && is_string($impactDetails->documents)) {
                $decodedEvidence = json_decode($impactDetails->documents, true);
                $documents       = is_array($decodedEvidence) ? $decodedEvidence : [];
            } else {
                $documents = is_array($impactDetails->documents) ? $impactDetails->documents : [];
            }

            foreach ($documents as &$item) {
                if (isset($item['gsutil_uri'])) {
                    $imageData        = $this->sdgService->getImageUrl($item['gsutil_uri']);
                    $item['fileName'] = $imageData['fileName'];
                    $item['imageUrl'] = $imageData['signedUrl'];
                }
            }

            $impactDetails->documents = $documents;

            return $impactDetails;
        });

        return response()->json($record, 200);
    }

    public function assignee()
    {
        $user = Auth::user();

        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'SDG Reporting')
            ->where('availability', 1)
            ->values();
        return response()->json($assignees);
    }

}
