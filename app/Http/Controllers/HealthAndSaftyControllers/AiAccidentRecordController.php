<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccidentRecord\AccidentRecordRequest;
use App\Repositories\All\AccidentPeople\AccidentPeopleInterface;
use App\Repositories\All\AccidentRecord\AccidentRecordInterface;
use App\Repositories\All\AccidentWitness\AccidentWitnessInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\AccidentService;
use Illuminate\Support\Facades\Auth;

class AiAccidentRecordController extends Controller
{
    protected $accidentRecordInterface;
    protected $accidentWitnessInterface;
    protected $accidentPeopleInterface;
    protected $userInterface;
    protected $accidentService;

    public function __construct(AccidentRecordInterface $accidentRecordInterface, AccidentWitnessInterface $accidentWitnessInterface, AccidentPeopleInterface $accidentPeopleInterface, UserInterface $userInterface, AccidentService $accidentService)
    {
        $this->accidentRecordInterface  = $accidentRecordInterface;
        $this->accidentWitnessInterface = $accidentWitnessInterface;
        $this->userInterface            = $userInterface;
        $this->accidentPeopleInterface  = $accidentPeopleInterface;
        $this->accidentService          = $accidentService;
    }

    public function index()
    {
        $records = $this->accidentRecordInterface->All();
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
                    $imageData        = $this->accidentService->getImageUrl($item['gsutil_uri']);
                    $item['fileName'] = $imageData['fileName'];
                    $item['imageUrl'] = $imageData['signedUrl'];
                }
            }

            $risk->evidence = $evidence;

            return $risk;
        });
        foreach ($records as $record) {
            $record->witnesses           = $this->accidentWitnessInterface->findByAccidentId($record->id);
            $record->effectedIndividuals = $this->accidentPeopleInterface->findByAccidentId($record->id);
        }

        return response()->json($records, 200);
    }

    public function store(AccidentRecordRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;

        $record = $this->accidentRecordInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create accident record'], 500);
        }

        $uploadedFiles = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $uploadedFiles[] = $this->accidentService->uploadImageToGCS($file);
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

            $this->accidentRecordInterface->update($record->id, [
                'evidence' => json_encode($mergedEvidence),
            ]);
        }

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['accidentId'] = $record->id;
                $this->accidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['accidentId'] = $record->id;
                $this->accidentPeopleInterface->create($person);
            }
        }

        return response()->json([
            'message' => 'Accident record created successfully',
            'record'  => $record,
        ], 201);
    }

    public function update(AccidentRecordRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->accidentRecordInterface->findById($id);

        if (! $record || ! is_object($record)) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }

        $documents = [];
        if (! empty($record->evidence)) {
            $decoded   = json_decode($record->evidence, true);
            $documents = is_array($decoded) ? $decoded : [];
        }

        if ($request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->accidentService->removeOldDocumentFromStorage($removeDoc);
                }

                $documents = array_values(array_filter($documents, function ($doc) use ($removeDocs) {
                    return ! in_array($doc['gsutil_uri'], $removeDocs);
                }));
            }
        }

        if ($request->hasFile('evidence')) {
            $newDocuments = [];
            $newFiles     = $request->file('evidence');

            foreach ($newFiles as $newFile) {
                $uploadResult = $this->accidentService->updateDocuments($newFile);

                if ($uploadResult && isset($uploadResult['gsutil_uri'])) {
                    $newDocuments[] = [
                        'gsutil_uri' => $uploadResult['gsutil_uri'],
                        'file_name'  => $uploadResult['file_name'],
                    ];
                }
            }

            if (! empty($newDocuments)) {
                $documents = array_merge($documents, $newDocuments);
            }
        }

        if ($request->has('removeDoc') || $request->hasFile('evidence')) {
            $data['evidence'] = json_encode(array_values($documents));
        }

        $updateSuccess = $this->accidentRecordInterface->update($id, $data);

        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update accident record'], 500);
        }

        $this->accidentWitnessInterface->deleteByAccidentId($id);
        $this->accidentPeopleInterface->deleteByAccidentId($id);

        if (! empty($data['witnesses'])) {
            foreach ($data['witnesses'] as $witness) {
                $witness['incidentId'] = $id;
                $this->accidentWitnessInterface->create($witness);
            }
        }

        if (! empty($data['effectedIndividuals'])) {
            foreach ($data['effectedIndividuals'] as $person) {
                $person['incidentId'] = $id;
                $this->accidentPeopleInterface->create($person);
            }
        }

        $updatedRecord                      = $this->accidentRecordInterface->findById($id);
        $updatedRecord->witnesses           = $this->accidentWitnessInterface->findByAccidentId($id);
        $updatedRecord->effectedIndividuals = $this->accidentPeopleInterface->findByAccidentId($id);

        if (! $updatedRecord || ! is_object($updatedRecord)) {
            return response()->json(['message' => 'Error fetching updated accident record'], 500);
        }

        return response()->json([
            'message' => 'Accident record updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    public function destroy(string $id)
    {
        $record = $this->accidentRecordInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Accident record not found'], 404);
        }

        $this->accidentWitnessInterface->deleteByAccidentId($id);
        $this->accidentPeopleInterface->deleteByAccidentId($id);

        if ($record->evidence) {
            $evidence = json_decode($record->evidence, true);

            if (is_array($evidence)) {
                foreach ($evidence as $item) {
                    if (isset($item['gsutil_uri'])) {
                        $this->accidentService->deleteImageFromGCS($item['gsutil_uri']);
                    }
                }
            }
        }

        $this->accidentRecordInterface->deleteById($id);

        return response()->json(['message' => 'Accident record deleted successfully'], 200);
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $record = $this->accidentRecordInterface->getByAssigneeId($user->id);

        $record = $record->map(function ($accident) {
            try {
                $assignee           = $this->userInterface->getById($accident->assigneeId);
                $accident->assignee = $assignee ? ['name' => $assignee->name, 'id' => $assignee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $accident->assignee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                     = $this->userInterface->getById($accident->createdByUser);
                $accident->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $accident->createdByUserName = 'Unknown';
            }
            if (! empty($accident->evidence) && is_string($accident->evidence)) {
                $decodedEvidence = json_decode($accident->evidence, true);
                $evidence        = is_array($decodedEvidence) ? $decodedEvidence : [];
            } else {
                $evidence = is_array($accident->evidence) ? $accident->evidence : [];
            }

            foreach ($evidence as &$item) {
                if (isset($item['gsutil_uri'])) {
                    $imageData        = $this->accidentService->getImageUrl($item['gsutil_uri']);
                    $item['fileName'] = $imageData['fileName'];
                    $item['imageUrl'] = $imageData['signedUrl'];
                }
            }

            $accident->evidence = $evidence;

            return $accident;
        });

        return response()->json($record, 200);
    }

    public function assignee()
    {
        $user = Auth::user();

        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Accident Section')
            ->where('availability', 1)
            ->values();
        return response()->json($assignees);
    }

}
