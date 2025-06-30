<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaGrGrievanceFeedbackRequest\GrievanceFeedbackRequest;
use App\Http\Requests\SaGrievanceRecord\GrievanceRecordRequest;
use App\Http\Requests\SaGrievanceRecord\GrStoreComGriRequest;
use App\Http\Requests\SaGrievanceRecord\GrStoreQuSuAppRequest;
use App\Repositories\All\SaGrCommiteeMemberDetails\GrCommiteeMemberDetailsInterface;
use App\Repositories\All\SaGrievanceRecord\GrievanceInterface;
use App\Repositories\All\SaGrLegalAdvisorDetails\GrLegalAdvisorDetailsInterface;
use App\Repositories\All\SaGrNomineeDetails\GrNomineeDetailsInterface;
use App\Repositories\All\SaGrRespondentDetails\GrRespondentDetailsInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\GrievanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaGrievanceRecodeController extends Controller
{
    protected $grievanceInterface;
    protected $commiteeMemberDetailsInterface;
    protected $legalAdvisorDetailsInterface;
    protected $nomineeDetailsInterface;
    protected $respondentDetailsInterface;
    protected $userInterface;
    protected $grievanceService;

    public function __construct(GrievanceInterface $grievanceInterface, GrCommiteeMemberDetailsInterface $commiteeMemberDetailsInterface, GrLegalAdvisorDetailsInterface $legalAdvisorDetailsInterface, GrNomineeDetailsInterface $nomineeDetailsInterface, GrRespondentDetailsInterface $respondentDetailsInterface, UserInterface $userInterface, GrievanceService $grievanceService)
    {
        $this->grievanceInterface             = $grievanceInterface;
        $this->commiteeMemberDetailsInterface = $commiteeMemberDetailsInterface;
        $this->legalAdvisorDetailsInterface   = $legalAdvisorDetailsInterface;
        $this->nomineeDetailsInterface        = $nomineeDetailsInterface;
        $this->respondentDetailsInterface     = $respondentDetailsInterface;
        $this->userInterface                  = $userInterface;
        $this->grievanceService               = $grievanceService;
    }

    private function resolveGcsFiles($field)
    {
        $files = [];

        if (! empty($field) && is_string($field)) {
            $decoded = json_decode($field, true);
            $files   = is_array($decoded) ? $decoded : [];
        } elseif (is_array($field)) {
            $files = $field;
        }

        foreach ($files as &$item) {
            if (isset($item['gsutil_uri'])) {
                $fileData         = $this->grievanceService->getImageUrl($item['gsutil_uri']);
                $item['fileName'] = $fileData['fileName'];
                $item['imageUrl'] = $fileData['signedUrl'];
            }
        }

        return $files;
    }

    private function safeUser($userId)
    {
        try {
            return $this->userInterface->getById($userId) ?? (object) [
                'id'   => null,
                'name' => 'Unknown',
            ];
        } catch (\Exception $e) {
            return (object) [
                'id'   => null,
                'name' => 'Unknown',
            ];
        }
    }

    public function index()
    {
        $records = $this->grievanceInterface->All()
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

        $records = $records->map(function ($record) {
            $record->createdByUser    = $this->safeUser($record->createdByUserId);
            $record->updatedByUser    = $this->safeUser($record->updatedByUserId);
            $record->inprogressByUser = $this->safeUser($record->inprogressByUserId);
            $record->completedByUser  = $this->safeUser($record->completedByUserId);
            $record->assignee         = $this->safeUser($record->assigneeId);

            $record->statementDocuments                       = $this->resolveGcsFiles($record->statementDocuments);
            $record->investigationCommitteeStatementDocuments = $this->resolveGcsFiles($record->investigationCommitteeStatementDocuments);
            $record->evidence                                 = $this->resolveGcsFiles($record->evidence);

            if ($record->isAnonymous) {
                $record->personType    = null;
                $record->name          = null;
                $record->gender        = null;
                $record->supervisor    = null;
                $record->employeeShift = null;
                $record->employeeId    = null;
                $record->location      = null;
            }
            $record->committeeMembers = $this->commiteeMemberDetailsInterface->findByGrievanceId($record->id);
            $record->legalAdvisors    = $this->legalAdvisorDetailsInterface->findByGrievanceId($record->id);
            $record->nominees         = $this->nomineeDetailsInterface->findByGrievanceId($record->id);
            $record->respondents      = $this->respondentDetailsInterface->findByGrievanceId($record->id);
            return $record;
        });

        return response()->json($records);
    }

    public function store(GrievanceRecordRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;
        $record                = $this->grievanceInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create grievance record'], 500);
        }

        if (! empty($data['committeeMembers'])) {
            foreach ($data['committeeMembers'] as $member) {
                $member['grievanceId'] = $record->id;
                $this->commiteeMemberDetailsInterface->create($member);
            }
        }

        if (! empty($data['legalAdvisors'])) {
            foreach ($data['legalAdvisors'] as $advisor) {
                $advisor['grievanceId'] = $record->id;
                $this->legalAdvisorDetailsInterface->create($advisor);
            }
        }

        if (! empty($data['nominees'])) {
            foreach ($data['nominees'] as $nominee) {
                $nominee['grievanceId'] = $record->id;
                $this->nomineeDetailsInterface->create($nominee);
            }
        }

        if (! empty($data['respondents'])) {
            foreach ($data['respondents'] as $resp) {
                $resp['grievanceId'] = $record->id;
                $this->respondentDetailsInterface->create($resp);
            }
        }
        $uploadedFiles = [];
        if ($request->hasFile('statementDocuments')) {
            foreach ($request->file('statementDocuments') as $file) {
                $uploadedFiles[] = $this->grievanceService->uploadImageToGCS($file, 'statementDocuments');
            }
        }

        if (! empty($uploadedFiles)) {
            $existingStatement = (! empty($record->investigationCommitteeStatementDocuments) && is_string($record->investigationCommitteeStatementDocuments))
            ? json_decode($record->investigationCommitteeStatementDocuments, true)
            : [];

            if (! is_array($existingStatement)) {
                $existingStatement = [];
            }

            $mergedStatement = array_merge($existingStatement, $uploadedFiles);

            $this->grievanceInterface->update($record->id, [
                'statementDocuments' => json_encode($mergedStatement),
            ]);
        }

        $uploadedFiles = [];
        if ($request->hasFile('investigationCommitteeStatementDocuments')) {
            foreach ($request->file('investigationCommitteeStatementDocuments') as $file) {
                $uploadedFiles[] = $this->grievanceService->uploadImageToGCS($file, 'investigationCommitteeStatementDocuments');
            }
        }

        if (! empty($uploadedFiles)) {
            $existingCommittee = (! empty($record->investigationCommitteeStatementDocuments) && is_string($record->investigationCommitteeStatementDocuments))
            ? json_decode($record->investigationCommitteeStatementDocuments, true)
            : [];

            if (! is_array($existingCommittee)) {
                $existingCommittee = [];
            }

            $mergedCommittee = array_merge($existingCommittee, $uploadedFiles);

            $this->grievanceInterface->update($record->id, [
                'investigationCommitteeStatementDocuments' => json_encode($mergedCommittee),
            ]);
        }

        $uploadedFiles = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $uploadedFiles[] = $this->grievanceService->uploadImageToGCS($file, 'evidence');
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

            $this->grievanceInterface->update($record->id, [
                'evidence' => json_encode($mergedEvidence),
            ]);
        }

        return response()->json([
            'message' => 'Grievance record created successfully',
            'record'  => $record,
        ], 201);
    }

    public function storeQuSuApp(GrStoreQuSuAppRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                    = $request->validated();
        $data['createdByUserId'] = $user->id;
        if (isset($data['status']) && $data['status'] === 'open') {
            $data['openedByUserId'] = $user->id;
        }

        $record = $this->grievanceInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create grievance record'], 500);
        }
        $uploadedFiles = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $uploadedFiles[] = $this->grievanceService->uploadImageToGCS($file, 'evidence');
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

            $this->grievanceInterface->update($record->id, [
                'evidence' => json_encode($mergedEvidence),
            ]);
        }

        return response()->json([
            'message' => 'Grievance record created successfully',
            'record'  => $record,
        ], 201);
    }

    public function updateQuSuApp($id, GrievanceRecordRequest $request)
{
    $user   = Auth::user();
    $record = $this->grievanceInterface->findById($id);
    if (! $record) {
        return response()->json(['message' => 'Grievance record not found.'], 404);
    }

    $data   = $request->validated();
    $status = $data['status'] ?? null;

    if ($status === 'inprogress') {
        $data['inprogressByUserId'] = $user->id;
    }

    if ($status === 'open') {
        $data['openedByUserId'] = $user->id;
    }

    if ($status === 'completed') {
        $data['completedByUserId'] = $user->id;
    }

    $handleJsonColumn = function (string $column, string $removeKey, string $fileKey) use ($request, $record) {
        $existingRaw = $record->{$column} ?? '[]';
        $existing = is_array($existingRaw) ? $existingRaw : json_decode($existingRaw, true);
        $existing = $existing ?? [];

        if ($request->has($removeKey)) {
            foreach ((array) $request->input($removeKey) as $uri) {
                $this->grievanceService->removeOldDocumentFromStorage($uri);
            }
            $existing = array_filter($existing, fn($doc) => !in_array($doc['gsutil_uri'], $request->input($removeKey)));
            $existing = array_values($existing); // reindex array
        }

        if ($request->hasFile($fileKey)) {
            foreach ($request->file($fileKey) as $file) {
                $res = $this->grievanceService->updateDocuments($file);
                if (!empty($res['gsutil_uri'])) {
                    $existing[] = [
                        'gsutil_uri' => $res['gsutil_uri'],
                        'file_name'  => $res['file_name'],
                    ];
                }
            }
        }

        return json_encode($existing);
    };

    $data['statementDocuments'] = $handleJsonColumn(
        'statementDocuments',
        'removeStatementDocuments',
        'statementDocuments'
    );
    $data['investigationCommitteeStatementDocuments'] = $handleJsonColumn(
        'investigationCommitteeStatementDocuments',
        'removeInvestigationCommitteeStatementDocuments',
        'investigationCommitteeStatementDocuments'
    );
    $data['evidence'] = $handleJsonColumn(
        'evidence',
        'removeEvidence',
        'evidence'
    );

    $updated = $this->grievanceInterface->update($id, $data);

    $this->commiteeMemberDetailsInterface->deleteByGrievanceId($id);
    foreach ($data['committeeMembers'] ?? [] as $m) {
        $m['grievanceId'] = $id;
        $this->commiteeMemberDetailsInterface->create($m);
    }

    $this->legalAdvisorDetailsInterface->deleteByGrievanceId($id);
    foreach ($data['legalAdvisors'] ?? [] as $a) {
        $a['grievanceId'] = $id;
        $this->legalAdvisorDetailsInterface->create($a);
    }

    $this->nomineeDetailsInterface->deleteByGrievanceId($id);
    foreach ($data['nominees'] ?? [] as $n) {
        $n['grievanceId'] = $id;
        $this->nomineeDetailsInterface->create($n);
    }

    $this->respondentDetailsInterface->deleteByGrievanceId($id);
    foreach ($data['respondents'] ?? [] as $r) {
        $r['grievanceId'] = $id;
        $this->respondentDetailsInterface->create($r);
    }

    return response()->json([
        'message' => $updated
            ? 'Grievance record updated successfully.'
            : 'Update failed.',
        'record'  => $this->grievanceInterface->findById($id),
    ], $updated ? 200 : 500);
}

    public function storeComGri(GrStoreComGriRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                    = $request->validated();
        $data['createdByUserId'] = $user->id;
        if (isset($data['status']) && $data['status'] === 'open') {
            $data['openedByUserId'] = $user->id;
        }

        $record = $this->grievanceInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create grievance record'], 500);
        }
        $uploadedFiles = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $uploadedFiles[] = $this->grievanceService->uploadImageToGCS($file, 'evidence');
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

            $this->grievanceInterface->update($record->id, [
                'evidence' => json_encode($mergedEvidence),
            ]);
        }

        return response()->json([
            'message' => 'Grievance record created successfully',
            'record'  => $record,
        ], 201);
    }

    public function updateComGri($id, GrievanceRecordRequest $request)
    {
        $user   = Auth::user();
        $record = $this->grievanceInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Grievance record not found.'], 404);
        }

        $data = $request->validated();

        $status = $data['status'] ?? null;

        if ($status === 'inprogress') {
            $data['inprogressByUserId'] = $user->id;
        }

        if ($status === 'open') {
            $data['openedByUserId'] = $user->id;
        }

        if ($status === 'completed') {
            $data['completedByUserId'] = $user->id;
        }

        $handleJsonColumn = function (string $column, string $removeKey, string $fileKey) use ($request, $record) {
            $existing = json_decode($record->{$column} ?? '[]', true);

            if ($request->has($removeKey)) {
                foreach ((array) $request->input($removeKey) as $uri) {
                    $this->grievanceService->removeOldDocumentFromStorage($uri);
                }
                $existing = array_filter($existing, fn($doc) => ! in_array($doc['gsutil_uri'], $request->input($removeKey)));
                $existing = array_values($existing);
            }

            if ($request->hasFile($fileKey)) {
                foreach ($request->file($fileKey) as $file) {
                    $res = $this->grievanceService->updateDocuments($file);
                    if (! empty($res['gsutil_uri'])) {
                        $existing[] = [
                            'gsutil_uri' => $res['gsutil_uri'],
                            'file_name'  => $res['file_name'],
                        ];
                    }
                }
            }

            return json_encode($existing);
        };

        $data['statementDocuments'] = $handleJsonColumn(
            'statementDocuments',
            'removeStatementDocuments',
            'statementDocuments'
        );
        $data['investigationCommitteeStatementDocuments'] = $handleJsonColumn(
            'investigationCommitteeStatementDocuments',
            'removeInvestigationCommitteeStatementDocuments',
            'investigationCommitteeStatementDocuments'
        );
        $data['evidence'] = $handleJsonColumn(
            'evidence',
            'removeEvidence',
            'evidence'
        );

        $updated = $this->grievanceInterface->update($id, $data);

        $this->commiteeMemberDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['committeeMembers'] ?? [] as $m) {
            $m['grievanceId'] = $id;
            $this->commiteeMemberDetailsInterface->create($m);
        }

        $this->legalAdvisorDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['legalAdvisors'] ?? [] as $a) {
            $a['grievanceId'] = $id;
            $this->legalAdvisorDetailsInterface->create($a);
        }

        $this->nomineeDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['nominees'] ?? [] as $n) {
            $n['grievanceId'] = $id;
            $this->nomineeDetailsInterface->create($n);
        }

        $this->respondentDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['respondents'] ?? [] as $r) {
            $r['grievanceId'] = $id;
            $this->respondentDetailsInterface->create($r);
        }

        return response()->json([
            'message' => $updated
            ? 'Grievance record updated successfully.'
            : 'Update failed.',
            'record'  => $this->grievanceInterface->findById($id),
        ], $updated ? 200 : 500);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $record = $this->grievanceInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Grievance record not found'], 404);
        }

        $status     = $request->input('status');
        $assigneeId = $request->input('assigneeId');

        $validStatuses = ['draft', 'open', 'inprogress', 'completed'];
        if (! in_array($status, $validStatuses)) {
            return response()->json(['message' => 'Invalid status'], 422);
        }

        $updateData = [
            'status'          => $status,
            'updatedByUserId' => $user->id,
        ];

        if (! is_null($assigneeId)) {
            $updateData['assigneeId'] = $assigneeId;
        }

        if ($status === 'inprogress') {
            $updateData['inprogressByUserId'] = $user->id;
        }

        if ($status === 'open') {
            $updateData['openedByUserId'] = $user->id;
        }

        if ($status === 'completed') {
            $updateData['completedByUserId'] = $user->id;
        }

        $updated = $this->grievanceInterface->update($id, $updateData);

        if ($updated) {
            return response()->json([
                'message' => "Grievance record updated to '{$status}'",
                'record'  => $this->grievanceInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update grievance record'], 500);
        }
    }

    public function updateCompleteStatus($id, GrievanceRecordRequest $request)
    {
        $user   = Auth::user();
        $record = $this->grievanceInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Grievance record not found.'], 404);
        }

        $data             = $request->validated();
        $handleJsonColumn = function (string $column, string $removeKey, string $fileKey) use ($request, $record) {
            $existing = json_decode($record->{$column} ?? '[]', true);

            if ($request->has($removeKey)) {
                foreach ((array) $request->input($removeKey) as $uri) {
                    $this->grievanceService->removeOldDocumentFromStorage($uri);
                }
                $existing = array_filter($existing, fn($doc) => ! in_array($doc['gsutil_uri'], $request->input($removeKey)));
                $existing = array_values($existing);
            }

            if ($request->hasFile($fileKey)) {
                foreach ($request->file($fileKey) as $file) {
                    $res = $this->grievanceService->updateDocuments($file);
                    if (! empty($res['gsutil_uri'])) {
                        $existing[] = [
                            'gsutil_uri' => $res['gsutil_uri'],
                            'file_name'  => $res['file_name'],
                        ];
                    }
                }
            }

            return json_encode($existing);
        };

        $data['statementDocuments'] = $handleJsonColumn(
            'statementDocuments',
            'removeStatementDocuments',
            'statementDocuments'
        );
        $data['investigationCommitteeStatementDocuments'] = $handleJsonColumn(
            'investigationCommitteeStatementDocuments',
            'removeInvestigationCommitteeStatementDocuments',
            'investigationCommitteeStatementDocuments'
        );
        $data['evidence'] = $handleJsonColumn(
            'evidence',
            'removeEvidence',
            'evidence'
        );

        $data['status']            = 'completed';
        $data['completedUserById'] = $user->id;
        $updated                   = $this->grievanceInterface->update($id, $data);

        $this->commiteeMemberDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['committeeMembers'] ?? [] as $m) {
            $m['grievanceId'] = $id;
            $this->commiteeMemberDetailsInterface->create($m);
        }

        $this->legalAdvisorDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['legalAdvisors'] ?? [] as $a) {
            $a['grievanceId'] = $id;
            $this->legalAdvisorDetailsInterface->create($a);
        }

        $this->nomineeDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['nominees'] ?? [] as $n) {
            $n['grievanceId'] = $id;
            $this->nomineeDetailsInterface->create($n);
        }

        $this->respondentDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['respondents'] ?? [] as $r) {
            $r['grievanceId'] = $id;
            $this->respondentDetailsInterface->create($r);
        }

        return response()->json([
            'message' => $updated
            ? 'Grievance record updated successfully.'
            : 'Update failed.',
            'record'  => $this->grievanceInterface->findById($id),
        ], $updated ? 200 : 500);
    }

    public function update($id, GrievanceRecordRequest $request)
    {
        $record = $this->grievanceInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Grievance record not found.'], 404);
        }

        $data             = $request->validated();
        $handleJsonColumn = function (string $column, string $removeKey, string $fileKey) use ($request, $record) {
            $existing = json_decode($record->{$column} ?? '[]', true);

            if ($request->has($removeKey)) {
                foreach ((array) $request->input($removeKey) as $uri) {
                    $this->grievanceService->removeOldDocumentFromStorage($uri);
                }
                $existing = array_filter($existing, fn($doc) => ! in_array($doc['gsutil_uri'], $request->input($removeKey)));
                $existing = array_values($existing);
            }

            if ($request->hasFile($fileKey)) {
                foreach ($request->file($fileKey) as $file) {
                    $res = $this->grievanceService->updateDocuments($file);
                    if (! empty($res['gsutil_uri'])) {
                        $existing[] = [
                            'gsutil_uri' => $res['gsutil_uri'],
                            'file_name'  => $res['file_name'],
                        ];
                    }
                }
            }

            return json_encode($existing);
        };

        $data['statementDocuments'] = $handleJsonColumn(
            'statementDocuments',
            'removeStatementDocuments',
            'statementDocuments'
        );
        $data['investigationCommitteeStatementDocuments'] = $handleJsonColumn(
            'investigationCommitteeStatementDocuments',
            'removeInvestigationCommitteeStatementDocuments',
            'investigationCommitteeStatementDocuments'
        );
        $data['evidence'] = $handleJsonColumn(
            'evidence',
            'removeEvidence',
            'evidence'
        );

        $updated = $this->grievanceInterface->update($id, $data);

        $this->commiteeMemberDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['committeeMembers'] ?? [] as $m) {
            $m['grievanceId'] = $id;
            $this->commiteeMemberDetailsInterface->create($m);
        }

        $this->legalAdvisorDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['legalAdvisors'] ?? [] as $a) {
            $a['grievanceId'] = $id;
            $this->legalAdvisorDetailsInterface->create($a);
        }

        $this->nomineeDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['nominees'] ?? [] as $n) {
            $n['grievanceId'] = $id;
            $this->nomineeDetailsInterface->create($n);
        }

        $this->respondentDetailsInterface->deleteByGrievanceId($id);
        foreach ($data['respondents'] ?? [] as $r) {
            $r['grievanceId'] = $id;
            $this->respondentDetailsInterface->create($r);
        }

        return response()->json([
            'message' => $updated
            ? 'Grievance record updated successfully.'
            : 'Update failed.',
            'record'  => $this->grievanceInterface->findById($id),
        ], $updated ? 200 : 500);
    }

    public function destroy($id)
    {
        $record = $this->grievanceInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Grievance record not found.'], 404);
        }

        $fields = [
            'statementDocuments',
            'investigationCommitteeStatementDocuments',
            'evidence',
        ];

        foreach ($fields as $field) {
            $documents = is_string($record->$field)
            ? json_decode($record->$field, true)
            : $record->$field;

            if (is_array($documents)) {
                foreach ($documents as $doc) {
                    $this->grievanceService->deleteImageFromGCS($doc);
                }
            }
        }

        $this->commiteeMemberDetailsInterface->deleteByGrievanceId($id);
        $this->legalAdvisorDetailsInterface->deleteByGrievanceId($id);
        $this->nomineeDetailsInterface->deleteByGrievanceId($id);
        $this->respondentDetailsInterface->deleteByGrievanceId($id);

        $deleted = $this->grievanceInterface->deleteById($id);

        return response()->json([
            'message' => $deleted ? 'Grievance record deleted successfully.' : 'Failed to delete record.',
        ], $deleted ? 200 : 500);
    }

    public function updateFeedback($id, GrievanceFeedbackRequest $request)
    {
        $record = $this->grievanceInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Grievance record not found.'], 404);
        }

        $data           = $request->only(['feedback', 'stars']);
        $data['status'] = 'completed';

        $updated = $this->grievanceInterface->update($id, $data);

        return response()->json([
            'message' => $updated
            ? 'Feedback updated successfully.'
            : 'Feedback update failed.',
            'record'  => $this->grievanceInterface->findById($id),
        ], $updated ? 200 : 500);
    }

    public function assignTask()
    {

        $assigneeId = Auth::id();

        $tasks = $this->grievanceInterface
            ->getByAssigneeId($assigneeId)
            ->filter(fn($g) => $g->status !== 'completed')
            ->sortByDesc('created_at')
            ->values();

        $tasks = $tasks->map(function ($tasks) {
            $tasks->createdByUser    = $this->safeUser($tasks->createdByUserId);
            $tasks->updatedByUser    = $this->safeUser($tasks->updatedByUserId);
            $tasks->inprogressByUser = $this->safeUser($tasks->inprogressByUserId);
            $tasks->completedByUser  = $this->safeUser($tasks->completedByUserId);

            $tasks->statementDocuments                       = $this->resolveGcsFiles($tasks->statementDocuments);
            $tasks->investigationCommitteeStatementDocuments = $this->resolveGcsFiles($tasks->investigationCommitteeStatementDocuments);
            $tasks->evidence                                 = $this->resolveGcsFiles($tasks->evidence);

            if ($tasks->isAnonymous) {
                $tasks->personType    = null;
                $tasks->name          = null;
                $tasks->gender        = null;
                $tasks->supervisor    = null;
                $tasks->employeeShift = null;
                $tasks->location      = null;
            }
            return $tasks;
        });

        return response()->json($tasks, 200);
    }

    public function assignTaskComplete()
    {
        $assigneeId = Auth::id();

        $tasks = $this->grievanceInterface
            ->getByAssigneeId($assigneeId)
            ->filter(fn($g) => $g->status === 'completed')
            ->sortByDesc('created_at')
            ->values();

        $tasks = $tasks->map(function ($tasks) {
            $tasks->createdByUser    = $this->safeUser($tasks->createdByUserId);
            $tasks->updatedByUser    = $this->safeUser($tasks->updatedByUserId);
            $tasks->inprogressByUser = $this->safeUser($tasks->inprogressByUserId);
            $tasks->completedByUser  = $this->safeUser($tasks->completedByUserId);

            $tasks->statementDocuments                       = $this->resolveGcsFiles($tasks->statementDocuments);
            $tasks->investigationCommitteeStatementDocuments = $this->resolveGcsFiles($tasks->investigationCommitteeStatementDocuments);
            $tasks->evidence                                 = $this->resolveGcsFiles($tasks->evidence);

            if ($tasks->isAnonymous) {
                $tasks->personType    = null;
                $tasks->name          = null;
                $tasks->gender        = null;
                $tasks->supervisor    = null;
                $tasks->employeeShift = null;
                $tasks->location      = null;
            }

            return $tasks;
        });

        return response()->json($tasks, 200);
    }

    public function updateStatusToApproved($id)
    {
        $user = Auth::user();

        if ($user->assigneeLevel != 5) {
            return response()->json(['message' => 'Unauthorized. Only CEO assignees can approve.'], 403);
        }

        $grievance = $this->grievanceInterface->findById($id);

        if (! $grievance) {
            return response()->json(['message' => 'Grievance record not found.'], 404);
        }

        $updated = $this->grievanceInterface->update($id, ['status' => 'Approved']);

        if ($updated) {
            return response()->json([
                'message'   => 'Grievance record approved successfully!',
                'grievance' => $this->grievanceInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to approve the hazard and risk record.'], 500);
        }
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Grievance Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }

}
