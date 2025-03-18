<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncidentRecode\IncidentRecodeRequest;
use App\Repositories\All\IncidentPeople\IncidentPeopleInterface;
use App\Repositories\All\IncidentRecord\IncidentRecodeInterface;
use App\Repositories\All\IncidentWitness\IncidentWitnessInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\IncidentService;
use Illuminate\Support\Facades\Auth;

class AiIncidentRecodeController extends Controller
{
    protected $incidentRecordInterface;
    protected $incidentWitnessInterface;
    protected $incidentPeopleInterface;
    protected $userInterface;
    protected $incidentService;

    public function __construct(IncidentRecodeInterface $incidentRecordInterface, IncidentWitnessInterface $incidentWitnessInterface, IncidentPeopleInterface $incidentPeopleInterface, UserInterface $userInterface, IncidentService $incidentService)
    {
        $this->incidentRecordInterface  = $incidentRecordInterface;
        $this->incidentWitnessInterface = $incidentWitnessInterface;
        $this->incidentPeopleInterface  = $incidentPeopleInterface;
        $this->userInterface            = $userInterface;
        $this->incidentService          = $incidentService;

    }

    public function index()
    {
        $records = $this->incidentRecordInterface->All();
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

            if (! empty($risk->evidence) && is_string($risk->evidence)) {
                $decodedEvidence = json_decode($risk->evidence, true);
                $evidence        = is_array($decodedEvidence) ? $decodedEvidence : [];
            } else {
                $evidence = is_array($risk->evidence) ? $risk->evidence : [];
            }

            foreach ($evidence as &$item) {
                if (isset($item['gsutil_uri'])) {
                    $imageData         = $this->incidentService->getImageUrl($item['gsutil_uri']);
                    $item['fileName']  = $imageData['fileName'];
                    $item['imageUrl'] = $imageData['signedUrl'];
                }
            }

            $risk->evidence = $evidence;

            return $risk;
        });

        foreach ($records as $record) {
            $record->witnesses           = $this->incidentWitnessInterface->findByIncidentId($record->id);
            $record->effectedIndividuals = $this->incidentPeopleInterface->findByIncidentId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(IncidentRecodeRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;
        $record                = $this->incidentRecordInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create Incident record'], 500);
        }

        $uploadedFiles = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $uploadedFiles[] = $this->incidentService->uploadImageToGCS($file);
            }
        }
        if (! empty($uploadedFiles)) {
            $existingEvidence = (! empty($record->evidence) && is_string($record->evidence))
            ? json_decode($record->evidence, true)
            : [];

            if (! is_array($existingEvidence)) {
                $existingEvidence = [];
            }

            $mergedEvidence = array_merge($existingEvidence, $uploadedFiles);

            $this->incidentRecordInterface->update($record->id, [
                'evidence' => json_encode($mergedEvidence), // Store as a JSON array
            ]);
        }

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['incidentId'] = $record->id;
                $this->incidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['incidentId'] = $record->id;
                $this->incidentPeopleInterface->create($person);
            }
        }

        return response()->json([
            'message' => 'Incident record created successfully',
            'record'  => $record,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncidentRecodeRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->incidentRecordInterface->findById($id);

        if (! $record || ! is_object($record)) {
            return response()->json(['message' => 'Incident record not found']);
        }
        if ($request->hasFile('evidence')) {
            $uploadedFiles = [];

            foreach ($request->file('evidence') as $file) {
                $uploadedFiles[] = $this->incidentService->uploadImageToGCS($file);
            }

            $validatedData['evidence'] = $uploadedFiles;
        }

        $updateSuccess = $record->update($data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update incident record'], 500);
        }

        $this->incidentWitnessInterface->deleteByIncidentId($id);
        $this->incidentPeopleInterface->deleteByIncidentId($id);

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['incidentId'] = $id;
                $this->incidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['incidentId'] = $id;
                $this->incidentPeopleInterface->create($person);
            }
        }

        $updatedRecord                      = $this->incidentRecordInterface->findById($id);
        $updatedRecord->witnesses           = $this->incidentWitnessInterface->findByIncidentId($id);
        $updatedRecord->effectedIndividuals = $this->incidentPeopleInterface->findByIncidentId($id);

        return response()->json([
            'message' => 'Incident record updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = $this->incidentRecordInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Incident record not found']);
        }

        $this->incidentWitnessInterface->deleteByIncidentId($id);

        $this->incidentPeopleInterface->deleteByIncidentId($id);

        $this->incidentRecordInterface->deleteById($id);

        return response()->json(['message' => 'Incident record deleted successfully'], 200);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $record = $this->incidentRecordInterface->getByAssigneeId($user->id);

        $record = $record->map(function ($incident) {
            try {
                $assignee           = $this->userInterface->getById($incident->assigneeId);
                $incident->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $incident->assignee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                     = $this->userInterface->getById($incident->createdByUser);
                $incident->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $incident->createdByUserName = 'Unknown';
            }

            return $incident;
        });

        return response()->json($record, 200);
    }

    public function assignee()
    {
        $user = Auth::user();

        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Incident Section')
            ->where('availability', 1);
        return response()->json($assignees);
    }

}
