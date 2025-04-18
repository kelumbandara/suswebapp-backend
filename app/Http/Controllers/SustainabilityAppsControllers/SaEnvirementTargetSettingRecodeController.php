<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaEnvirementTargetSettingRecode\TargetSettingRecodeRequest;
use App\Repositories\All\SaETargetSetting\TargetSettingRecodeInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\TargetSettingService;
use Illuminate\Support\Facades\Auth;

class SaEnvirementTargetSettingRecodeController extends Controller
{

    protected $targetSettingRecodeInterface;
    protected $userInterface;
    protected $TargetSettingService;

    public function __construct(TargetSettingRecodeInterface $targetSettingRecodeInterface, UserInterface $userInterface, TargetSettingService $TargetSettingService)
    {
        $this->targetSettingRecodeInterface = $targetSettingRecodeInterface;
        $this->userInterface          = $userInterface;
        $this->TargetSettingService   = $TargetSettingService;
    }
    public function index()
    {
        $targetSetting = $this->targetSettingRecodeInterface->All();

        $targetSetting = $targetSetting->map(function ($risk) {
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
                    $imageData            = $this->TargetSettingService->getImageUrl($document['gsutil_uri']);
                    $document['imageUrl'] = $imageData['signedUrl'];
                    $document['fileName'] = $imageData['fileName'];
                }
            }

            $risk->documents = $documents;
            return $risk;
        });

        return response()->json($targetSetting, 200);
    }

    public function store(TargetSettingRecodeRequest $request)
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
                $uploadedFiles[] = $this->TargetSettingService->uploadImageToGCS($file);
            }

            $validatedData['documents'] = json_encode($uploadedFiles);
        }

        $targetSetting = $this->targetSettingRecodeInterface->create($validatedData);

        return response()->json([
            'message'    => 'Target setting record created successfully!',
            'targetSetting' => $targetSetting,
        ], 201);
    }



    public function update($id, TargetSettingRecodeRequest $request)
    {
        $targetSetting = $this->targetSettingRecodeInterface->findById($id);

        if (!$targetSetting) {
            return response()->json(['message' => 'Target setting record not found.'], 404);
        }

        $validatedData = $request->validated();

        $documents = json_decode($targetSetting->documents, true) ?? [];

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->TargetSettingService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($doc) use ($removeDocs) {
                    return !in_array($doc['gsutil_uri'], $removeDocs);
                }));
            }
        }

        if ($request->hasFile('documents')) {
            $newDocuments = [];
            foreach ($request->file('documents') as $newFile) {
                $uploadResult = $this->TargetSettingService->updateDocuments($newFile);

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

        $updated = $this->targetSettingRecodeInterface->update($id, $validatedData);

        if ($updated) {
            return response()->json([
                'message'    => 'Target setting record updated successfully!',
                'targetSetting' => $this->targetSettingRecodeInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the target setting record.'], 500);
        }
    }


    public function destroy($id)
    {
        $targetSetting = $this->targetSettingRecodeInterface->findById((int) $id);

        if (! empty($targetSetting->documents)) {
            if (is_string($targetSetting->documents)) {
                $documents = json_decode($targetSetting->documents, true);
            } else {
                $documents = $targetSetting->documents;
            }

            if (is_array($documents)) {
                foreach ($documents as $document) {
                    $this->TargetSettingService->deleteImageFromGCS($document);
                }
            }
        }

        $deleted = $this->targetSettingRecodeInterface->deleteById($id);

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

        $targetSetting = $this->targetSettingRecodeInterface->getByAssigneeId($user->id);

        $targetSetting = $targetSetting->map(function ($risk) {
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
                    $imageData            = $this->TargetSettingService->getImageUrl($document['gsutil_uri']);
                    $document['imageUrl'] = $imageData['signedUrl'];
                    $document['fileName'] = $imageData['fileName'];
                }
            }

            $risk->documents = $documents;
            return $risk;
        });

        return response()->json($targetSetting, 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Target Setting Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }


}
