<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiEaActionPlan\EaActionPlanRequest;
use App\Http\Requests\SaAiExternalAudit\ExternalAuditRequest;
use App\Models\User;
use App\Repositories\All\ComDepartment\DepartmentInterface;
use App\Repositories\All\SaAiEaActionPlan\EaActionPlanInterface;
use App\Repositories\All\SaAiExternalAudit\ExternalAuditInterface;
use App\Repositories\All\SaAiIaActionPlan\ActionPlanInterface;
use App\Repositories\All\SaAiIaAnswerRecode\AnswerRecodeInterface;
use App\Repositories\All\SaAiIaContactPerson\ContactPersonInterface;
use App\Repositories\All\SaAiIaQrGroupRecode\GroupRecodeInterface;
use App\Repositories\All\SaAiIaQrQuection\QuestionsInterface;
use App\Repositories\All\SaAiIaQuestionRecode\QuestionRecodeInterface;
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
    protected $answerRecodeInterface;
    protected $questionRecodeInterface;
    protected $eaActionPlanInterface;
    protected $actionPlanInterface;
    protected $contactPersonInterface;
    protected $questionsInterface;
    protected $departmentInterface;
    protected $groupRecodeInterface;

    public function __construct(ExternalAuditInterface $externalAuditInterface, QuestionRecodeInterface $questionRecodeInterface, AnswerRecodeInterface $answerRecodeInterface, UserInterface $userInterface, ExternalAuditService $externalAuditService, GroupRecodeInterface $groupRecodeInterface, DepartmentInterface $departmentInterface, QuestionsInterface $questionsInterface, ContactPersonInterface $contactPersonInterface, InternalAuditRecodeInterface $internalAuditRecodeInterface, EaActionPlanInterface $eaActionPlanInterface, ActionPlanInterface $actionPlanInterface)
    {
        $this->externalAuditInterface       = $externalAuditInterface;
        $this->userInterface                = $userInterface;
        $this->externalAuditService         = $externalAuditService;
        $this->internalAuditRecodeInterface = $internalAuditRecodeInterface;
        $this->answerRecodeInterface        = $answerRecodeInterface;
        $this->questionRecodeInterface      = $questionRecodeInterface;
        $this->eaActionPlanInterface        = $eaActionPlanInterface;
        $this->actionPlanInterface          = $actionPlanInterface;
        $this->contactPersonInterface       = $contactPersonInterface;
        $this->questionsInterface           = $questionsInterface;
        $this->departmentInterface          = $departmentInterface;
        $this->groupRecodeInterface         = $groupRecodeInterface;
    }

    public function index()
    {
        $externalAudit = $this->externalAuditInterface->All()
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

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

            $actionPlans = $this->eaActionPlanInterface->findByExternalAuditId($audit->id);
            $actionPlans = collect($actionPlans)->map(function ($actionPlan) {
                try {
                    $approver             = $this->userInterface->getById($actionPlan->approverId);
                    $actionPlan->approver = $approver
                    ? ['name' => $approver->name, 'id' => $approver->id]
                    : ['name' => 'Unknown', 'id' => null];
                } catch (\Exception $e) {
                    $actionPlan->approver = ['name' => 'Unknown', 'id' => null];
                }
                return $actionPlan;
            });

            $audit->actionPlan = $actionPlans;

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
    public function actionPlanUpdate($id, EaActionPlanRequest $request)
    {
        $data = $request->validated();

        $updatedActionPlan = $this->eaActionPlanInterface->update($id, $data);

        return response()->json([
            'message' => 'Action plan updated successfully',
            'data'    => $updatedActionPlan,
        ], 200);
    }
    public function actionPlanStore(EaActionPlanRequest $request)
    {
        $data       = $request->validated();
        $actionplan = $this->eaActionPlanInterface->create($data);
        return response()->json([
            'message' => 'Action plan created successfully',
            'data'    => $actionplan,
        ], 201);

    }

    public function actionPlanDelete($id)
    {
        $actionplan = $this->eaActionPlanInterface->deleteById($id);
        return response()->json([
            'message' => $actionplan ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $actionplan ? 200 : 500);

    }

public function getCalendarRecord($startDate, $endDate)
{
    try {
        $externalAudits = $this->externalAuditInterface->getBetweenDates($startDate, $endDate)
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

        $externalAudits = $externalAudits->map(function ($audit) {
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

            $actionPlans = $this->eaActionPlanInterface->findByExternalAuditId($audit->id);
            $actionPlans = collect($actionPlans)->map(function ($actionPlan) {
                try {
                    $approver             = $this->userInterface->getById($actionPlan->approverId);
                    $actionPlan->approver = $approver
                        ? ['name' => $approver->name, 'id' => $approver->id]
                        : ['name' => 'Unknown', 'id' => null];
                } catch (\Exception $e) {
                    $actionPlan->approver = ['name' => 'Unknown', 'id' => null];
                }
                return $actionPlan;
            });

            $audit->actionPlan = $actionPlans;
            $audit->type       = 'external';

            try {
                $auditDate    = new \DateTime($audit->auditDate, new \DateTimeZone('UTC'));
                $audit->Date  = $auditDate->format('Y-m-d');
                $audit->Year  = $auditDate->format('Y');
                $audit->Month = $auditDate->format('m');
                $audit->Day   = $auditDate->format('d');
                $audit->Time  = $auditDate->format('H:i:s');
            } catch (\Exception $e) {
                $audit->Date  = null;
                $audit->Year  = null;
                $audit->Month = null;
                $audit->Time  = null;
            }

            return $audit;
        });

        $internalAudits = $this->internalAuditRecodeInterface->getBetweenDates($startDate, $endDate)
            ->sortByDesc('created_at')
            ->sortByDesc('updated_at')
            ->values();

        $internalAudits = $internalAudits->map(function ($audit) {
            try {
                $approver        = $this->userInterface->getById($audit->approverId);
                $audit->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $auditee        = $this->userInterface->getById($audit->auditeeId);
                $audit->auditee = $auditee ? ['name' => $auditee->name, 'id' => $auditee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->auditee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator                  = $this->userInterface->getById($audit->createdByUser);
                $audit->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $audit->createdByUserName = 'Unknown';
            }

            try {
                $contactPerson               = $this->contactPersonInterface->getById($audit->factoryContactPersonId);
                $audit->factoryContactPerson = $contactPerson
                    ? ['name' => $contactPerson->name, 'id' => $contactPerson->id]
                    : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->factoryContactPerson = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $questionRecode = $this->questionRecodeInterface->getById($audit->auditId);
                $totalQuestions = 0;
                $totalScore     = 0;

                $groups = $this->groupRecodeInterface->findByQuestionRecoId($questionRecode->id);
                $groups = collect($groups)->map(function ($group) use (&$totalQuestions, &$totalScore) {
                    $questions        = $this->questionsInterface->findByQueGroupId($group->queGroupId);
                    $group->questions = $questions;
                    $totalQuestions += count($questions);
                    $totalScore += collect($questions)->sum('allocatedScore');
                    return $group;
                });

                $questionRecode->questionGroups         = $groups;
                $questionRecode->totalNumberOfQuestions = $totalQuestions;
                $questionRecode->achievableScore        = $totalScore;

                $audit->audit = $questionRecode;
            } catch (\Exception $e) {
                $audit->audit = null;
            }

            try {
                $departments = [];
                if (is_array($audit->department)) {
                    foreach ($audit->department as $dept) {
                        $deptId        = is_array($dept) && isset($dept['id']) ? $dept['id'] : $dept;
                        $department    = $this->departmentInterface->getById($deptId);
                        $departments[] = $department
                            ? ['department' => $department->department, 'id' => $department->id]
                            : ['department' => 'Unknown', 'id' => $deptId];
                    }
                }
                $audit->department = $departments;
            } catch (\Exception $e) {
                $audit->department = [['department' => 'Unknown', 'id' => null]];
            }

            $actionPlans = $this->actionPlanInterface->findByInternalAuditId($audit->id);
            $actionPlans = collect($actionPlans)->map(function ($actionPlan) {
                try {
                    $approver             = $this->userInterface->getById($actionPlan->approverId);
                    $actionPlan->approver = $approver
                        ? ['name' => $approver->name, 'id' => $approver->id]
                        : ['name' => 'Unknown', 'id' => null];
                } catch (\Exception $e) {
                    $actionPlan->approver = ['name' => 'Unknown', 'id' => null];
                }
                return $actionPlan;
            });

            $audit->actionPlan = $actionPlans;
            $audit->answers    = $this->answerRecodeInterface->findByInternalAuditId($audit->id);
            $audit->type       = 'internal';

            try {
                $auditDate    = new \DateTime($audit->auditDate, new \DateTimeZone('UTC'));
                $audit->Date  = $auditDate->format('Y-m-d');
                $audit->Year  = $auditDate->format('Y');
                $audit->Month = $auditDate->format('m');
                $audit->Day   = $auditDate->format('d');
                $audit->Time  = $auditDate->format('H:i:s');
            } catch (\Exception $e) {
                $audit->Date  = null;
                $audit->Year  = null;
                $audit->Month = null;
                $audit->Time  = null;
            }

            return $audit;
        });


        $combined = $externalAudits->concat($internalAudits)->sortByDesc('auditDate')->values();

        return response()->json($combined);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
    }
}


    public function getCombinedStatusCount($startDate = null, $endDate = null, $division = null, $type = null)
    {

        $statusSummary = [];
        $auditFeeTotal = 0;

        if ($type === 'External Audit' || $type === 'both') {
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

        if ($type === 'Internal Audit' || $type === 'both') {
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

    public function getCombinedScoreCountByMonth($startDate, $endDate, $division, $type)
    {
        $monthNames = [
            1  => 'January', 2  => 'February', 3  => 'March',
            4  => 'April', 5    => 'May', 6       => 'June',
            7  => 'July', 8     => 'August', 9    => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $rawMonthlyData = [];

        $startYear  = (int) date('Y', strtotime($startDate));
        $startMonth = (int) date('m', strtotime($startDate));
        $endYear    = (int) date('Y', strtotime($endDate));
        $endMonth   = (int) date('m', strtotime($endDate));

        for ($year = $startYear; $year <= $endYear; $year++) {
            $monthStart = ($year === $startYear) ? $startMonth : 1;
            $monthEnd   = ($year === $endYear) ? $endMonth : 12;

            for ($month = $monthStart; $month <= $monthEnd; $month++) {
                $monthStr     = str_pad($month, 2, '0', STR_PAD_LEFT);
                $startOfMonth = "$year-$monthStr-01";
                $endOfMonth   = date("Y-m-t", strtotime($startOfMonth));
                $monthName    = $monthNames[$month];

                if ($type === 'External Audit') {
                    $audits = $this->externalAuditInterface->filterByParams($startOfMonth, $endOfMonth, $division);

                    foreach ($audits as $audit) {
                        $score     = is_numeric($audit->auditScore) ? (float) $audit->auditScore : 0;
                        $auditType = $audit->auditType ?? 'Unknown';

                        $key = $monthName . '-' . $auditType;
                        if (! isset($rawMonthlyData[$key])) {
                            $rawMonthlyData[$key] = [
                                'month'      => $monthName,
                                'auditType'  => $auditType,
                                'totalScore' => 0,
                                'count'      => 0,
                            ];
                        }

                        $rawMonthlyData[$key]['totalScore'] += $score;
                        $rawMonthlyData[$key]['count']++;
                    }
                }

                if ($type === 'Internal Audit') {
                    $audits = $this->internalAuditRecodeInterface->filterByParams($startOfMonth, $endOfMonth, $division);

                    foreach ($audits as $audit) {
                        $answers = $this->answerRecodeInterface->findByInternalAuditId($audit->id);

                        $totalScore = 0;
                        foreach ($answers as $ans) {
                            $score = is_numeric($ans->score) ? (float) $ans->score : 0;
                            $totalScore += $score;
                        }

                        $auditType = $audit->auditType ?? 'Unknown';

                        $key = $monthName . '-' . $auditType;
                        if (! isset($rawMonthlyData[$key])) {
                            $rawMonthlyData[$key] = [
                                'month'      => $monthName,
                                'auditType'  => $auditType,
                                'totalScore' => 0,
                                'count'      => 0,
                            ];
                        }

                        $rawMonthlyData[$key]['totalScore'] += $totalScore;
                        $rawMonthlyData[$key]['count']++;
                    }
                }
            }
        }

        $formattedData = array_values($rawMonthlyData);

        return response()->json([
            'yearStart' => $startYear,
            'yearEnd'   => $endYear,
            'type'      => $type,
            'division'  => $division,
            'data'      => $formattedData,
        ]);
    }

    public function getCombinedStatusCountMonthly($startDate = null, $endDate = null, $division = null, $type = null)
    {
        $monthNames = [
            1  => 'January', 2  => 'February', 3  => 'March',
            4  => 'April', 5    => 'May', 6       => 'June',
            7  => 'July', 8     => 'August', 9    => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $monthlyStatusSummary = [];
        $monthlyAuditFeeTotal = [];

        $start = new \DateTime($startDate);
        $end   = new \DateTime($endDate);
        $end->modify('last day of this month');

        while ($start <= $end) {
            $year      = $start->format('Y');
            $month     = (int) $start->format('m');
            $monthName = $monthNames[$month] . " $year";

            $startOfMonth = $start->format('Y-m-01');
            $endOfMonth   = $start->format('Y-m-t');

            $statusSummary = [];
            $auditFeeTotal = 0;

            if ($type === 'External Audit' || $type === 'both') {
                $externalRecords = $this->externalAuditInterface->filterByParams($startOfMonth, $endOfMonth, $division);

                foreach ($externalRecords as $record) {
                    $status                 = strtolower(trim($record->status ?? 'unknown'));
                    $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;

                    if (is_numeric($record->auditFee)) {
                        $auditFeeTotal += floatval($record->auditFee);
                    }
                }
            }

            if ($type === 'Internal Audit' || $type === 'both') {
                $internalRecords = $this->internalAuditRecodeInterface->filterByParams($startOfMonth, $endOfMonth, $division);

                foreach ($internalRecords as $record) {
                    $status                 = strtolower(trim($record->status ?? 'unknown'));
                    $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;

                    if (is_numeric($record->auditFee)) {
                        $auditFeeTotal += floatval($record->auditFee);
                    }
                }
            }

            $monthlyStatusSummary[$monthName] = $statusSummary;
            $monthlyAuditFeeTotal[$monthName] = round($auditFeeTotal, 2);

            $start->modify('+1 month');
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'type'      => $type,
            'data'      => $monthlyStatusSummary,
        ]);
    }

    public function getStatusCountByMonth($startDate, $endDate, $year, $division, $type)
    {
        $monthNames = [
            1  => 'January', 2  => 'February', 3  => 'March',
            4  => 'April', 5    => 'May', 6       => 'June',
            7  => 'July', 8     => 'August', 9    => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $monthlyStatusCounts = [];

        for ($month = 1; $month <= 12; $month++) {
            $statusSummary = [];

            if ($type === 'External Audit' || $type === 'both') {
                $externalRecords = $this->externalAuditInterface
                    ->filterByYearMonthDivision($year, $month, $division);

                foreach ($externalRecords as $record) {
                    $status                 = strtolower(trim($record->status ?? 'unknown'));
                    $statusSummary[$status] = ($statusSummary[$status] ?? 0) + 1;
                }
            }

            if ($type === 'Internal Audit' || $type === 'both') {
                $internalRecords = $this->internalAuditRecodeInterface
                    ->filterByYearMonthDivision($year, $month, $division);

                foreach ($internalRecords as $record) {
                    $status                 = strtolower(trim($record->status ?? 'unknown'));
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

    public function getAssignedCompletionStats($startDate = null, $endDate = null, $division = null, $type = null)
    {
        $userStats = [];

        if ($type === 'External Audit' || $type === 'both') {
            $externalRecords = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division);

            foreach ($externalRecords as $record) {
                $userId = $record->representorId ?? null;
                if (! $userId) {
                    continue;
                }

                $status = $record->status ?? 'unknown';
                if (! isset($userStats[$userId])) {
                    $userStats[$userId] = ['total' => 0, 'completed' => 0];
                }

                $userStats[$userId]['total']++;
                if ($status === 'complete') {
                    $userStats[$userId]['completed']++;
                }
            }

        }

        if ($type === 'Internal Audit' || $type === 'both') {
            $internalRecords = $this->internalAuditRecodeInterface->filterByParams($startDate, $endDate, $division);

            foreach ($internalRecords as $record) {
                $userId = $record->auditeeId ?? null;
                if (! $userId) {
                    continue;
                }

                $status = $record->status ?? 'unknown';

                if (! isset($userStats[$userId])) {
                    $userStats[$userId] = ['total' => 0, 'completed' => 0];
                }

                $userStats[$userId]['total']++;
                if ($status === 'complete') {
                    $userStats[$userId]['completed']++;
                }
            }

        }

        $userIds = array_keys($userStats);
        $users   = $this->userInterface->getByIds($userIds);
        $results = [];
        foreach ($userStats as $userId => $stat) {
            $user = $users->get($userId);

            $results[] = [
                'userId'     => $userId,
                'userName'   => $user->name ?? "User #$userId",
                'userEmail'  => $user->email ?? null,
                'total'      => $stat['total'],
                'completed'  => $stat['completed'],
                'percentage' => $stat['total'] > 0 ? round(($stat['completed'] / $stat['total']) * 100, 2) : 0,
            ];
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'type'      => $type,
            'data'      => $results,
        ]);
    }

    public function getAuditGradeStats($startDate = null, $endDate = null, $division = null, $type = null)
    {
        if ($type === 'External Audit' || $type === 'both') {
            $gradeStats = [];

            $externalRecords = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division);
            $totalCount      = 0;

            foreach ($externalRecords as $record) {
                $grade = $record->auditGrade ?? 'Unknown';

                if (! isset($gradeStats[$grade])) {
                    $gradeStats[$grade] = 0;
                }

                $gradeStats[$grade]++;
                $totalCount++;
            }

            $results = [];

            foreach ($gradeStats as $grade => $count) {
                $results[] = [
                    'grade'      => $grade,
                    'count'      => $count,
                    'percentage' => $totalCount > 0 ? round(($count / $totalCount) * 100, 2) : 0,
                ];
            }

            return response()->json([
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'division'  => $division,
                'type'      => $type,
                'data'      => $results,
            ]);
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'type'      => $type,
            'data'      => null,
        ]);
    }

    public function getAuditAnnouncementStats($startDate = null, $endDate = null, $division = null, $type = null)
    {
        if ($type === 'External Audit' || $type === 'both') {
            $announcementStats = [];

            $externalRecords = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division);
            $totalCount      = 0;

            foreach ($externalRecords as $record) {
                $announcement = $record->announcement ?? 'Unknown';

                if (! isset($announcementStats[$announcement])) {
                    $announcementStats[$announcement] = 0;
                }

                $announcementStats[$announcement]++;
                $totalCount++;
            }

            $results = [];

            foreach ($announcementStats as $announcement => $count) {
                $results[] = [
                    'announcement' => $announcement,
                    'count'        => $count,
                    'percentage'   => $totalCount > 0 ? round(($count / $totalCount) * 100, 2) : 0,
                ];
            }

            return response()->json([
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'division'  => $division,
                'type'      => $type,
                'data'      => $results,
            ]);
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'type'      => $type,
            'data'      => null,
        ]);
    }

    public function getCategoryPriorityDistribution($startDate, $endDate, $division)
    {
        $results = [];

        $externalAudits = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division)
            ->filter(function ($audit) {
                return strtolower($audit->status) === 'complete';
            });

        $groupedByCategory = collect($externalAudits)->groupBy(function ($audit) {
            return $audit->auditCategory ?? 'Unknown';
        });

        foreach ($groupedByCategory as $category => $audits) {
            $priorityCounts = [];
            $validCount     = 0;

            foreach ($audits as $audit) {
                $actionPlans = $this->eaActionPlanInterface->findByExternalAuditId($audit->id);

                foreach ($actionPlans as $plan) {
                    $priority = $plan->priority;

                    if (empty($priority) || strtolower($priority) === 'unknown') {
                        continue;
                    }

                    if (! isset($priorityCounts[$priority])) {
                        $priorityCounts[$priority] = 0;
                    }

                    $priorityCounts[$priority]++;
                    $validCount++;
                }
            }

            if ($validCount === 0) {
                continue;
            }

            $results[] = [
                'category'   => $category,
                'total'      => $validCount,
                'priorities' => collect($priorityCounts)->map(function ($count, $priority) use ($validCount) {
                    return [
                        'priority'   => $priority,
                        'count'      => $count,
                        'percentage' => round(($count / $validCount) * 100, 2),
                    ];
                })->values()->all(),
            ];
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'division'  => $division,
            'data'      => $results,
        ]);
    }

    public function getSelectDivisionRecode($division, $type)
    {
        $records = collect();

        if ($type === 'External Audit' || $type === 'both') {
            $records = $records->merge($this->externalAuditInterface->filterByParams(null, null, $division));
        }

        if ($type === 'Internal Audit' || $type === 'both') {
            $records = $records->merge($this->internalAuditRecodeInterface->filterByParams(null, null, $division));
        }

        $groupedByYear = $records->groupBy(function ($record) {
            return \Carbon\Carbon::parse($record->updated_at)->format('Y');
        });

        $result = $groupedByYear->map(function ($items, $year) use ($division, $type) {
            return [
                'division' => $division,
                'type'     => $type,
                'year'     => (int) $year,
                'count'    => count($items),
            ];
        })->values();

        return response()->json($result);
    }

    public function getAllDivisionRecode($startDate, $endDate, $type)
    {
        $divisionStats = [];

        if ($type === 'External Audit' || $type === 'both') {
            $externalRecords = $this->externalAuditInterface->filterByParams($startDate, $endDate, null);

            foreach ($externalRecords as $record) {
                $division = $record->division ?? 'Unknown';

                if (! isset($divisionStats[$division])) {
                    $divisionStats[$division] = 0;
                }

                $divisionStats[$division]++;
            }
        }

        if ($type === 'Internal Audit' || $type === 'both') {
            $internalRecords = $this->internalAuditRecodeInterface->filterByParams($startDate, $endDate, null);

            foreach ($internalRecords as $record) {
                $division = $record->division ?? 'Unknown';

                if (! isset($divisionStats[$division])) {
                    $divisionStats[$division] = 0;
                }

                $divisionStats[$division]++;
            }
        }

        $results = [];

        foreach ($divisionStats as $division => $count) {
            $results[] = [
                'division' => $division,
                'count'    => $count,
            ];
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'type'      => $type,
            'data'      => $results,
        ]);
    }

    public function getAuditStandardsRecode($startDate, $endDate, $division, $type)
    {
        $auditStandards = [];

        if ($type === 'External Audit' || $type === 'both') {
            $externalRecords = $this->externalAuditInterface->filterByParams($startDate, $endDate, null);

            foreach ($externalRecords as $record) {
                $auditStandard = $record->auditStandard ?? 'Unknown';

                if (! isset($auditStandards[$auditStandard])) {
                    $auditStandards[$auditStandard] = 0;
                }

                $auditStandards[$auditStandard]++;
            }
        }

        if ($type === 'Internal Audit' || $type === 'both') {
            $internalRecords = $this->internalAuditRecodeInterface->filterByParams($startDate, $endDate, null);

            foreach ($internalRecords as $record) {
                $auditStandard = $record->auditStandard ?? 'Unknown';

                if (! isset($auditStandards[$auditStandard])) {
                    $auditStandards[$auditStandard] = 0;
                }

                $auditStandards[$auditStandard]++;
                return response()->json([
                    'startDate' => $startDate,
                    'endDate'   => $endDate,
                    'type'      => $type,
                    'data'      => null,
                ]);
            }
        }

        $results = [];

        foreach ($auditStandards as $auditStandard => $count) {
            $results[] = [
                'auditStandard' => $auditStandard,
                'count'         => $count,
            ];
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'type'      => $type,
            'data'      => $results,
        ]);
    }

    public function getAuditCompletionDraftStats($startDate = null, $endDate = null, $division = null, $type = null)
    {
        $allRecords          = collect();
        $timeFilteredRecords = collect();
        $internalRecords     = collect();
        $externalRecords     = collect();
        $internalTime        = collect();
        $externalTime        = collect();

        if ($type === 'External Audit' || $type === 'both') {
            $externalRecords     = $this->externalAuditInterface->filterByParams(null, null, $division);
            $externalTime        = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division);
            $allRecords          = $allRecords->merge($externalRecords);
            $timeFilteredRecords = $timeFilteredRecords->merge($externalTime);
        }

        if ($type === 'Internal Audit' || $type === 'both') {
            $internalRecords     = $this->internalAuditRecodeInterface->filterByParams(null, null, $division);
            $internalTime        = $this->internalAuditRecodeInterface->filterByParams($startDate, $endDate, $division);
            $allRecords          = $allRecords->merge($internalRecords);
            $timeFilteredRecords = $timeFilteredRecords->merge($internalTime);
        }

        $totalRecordsCount = $allRecords->count();

        $totalComplete = $externalRecords->filter(function ($r) {
            return strtolower(trim($r->status)) === 'complete';
        })->count() + $internalRecords->filter(function ($r) {
            return strtolower(trim($r->status)) === 'completed';
        })->count();

        $totalDraft = $externalRecords->filter(function ($r) {
            return strtolower(trim($r->status)) === 'draft';
        })->count() + $internalRecords->filter(function ($r) {
            return strtolower(trim($r->status)) === 'draft';
        })->count();

        $timeRangeRecordsCount = $timeFilteredRecords->count();

        $timeComplete = $externalTime->filter(function ($r) {
            return strtolower(trim($r->status)) === 'complete';
        })->count() + $internalTime->filter(function ($r) {
            return strtolower(trim($r->status)) === 'completed';
        })->count();

        $timeDraft = $externalTime->filter(function ($r) {
            return strtolower(trim($r->status)) === 'draft';
        })->count() + $internalTime->filter(function ($r) {
            return strtolower(trim($r->status)) === 'draft';
        })->count();

        return response()->json([
            'totalRecords'            => $totalRecordsCount,
            'totalComplete'           => $totalComplete,
            'totalDraft'              => $totalDraft,
            'totalCompletePercentage' => $totalRecordsCount ? round(($totalComplete / $totalRecordsCount) * 100, 2) : 0,
            'totalDraftPercentage'    => $totalRecordsCount ? round(($totalDraft / $totalRecordsCount) * 100, 2) : 0,

            'timeRangeRecords'        => $timeRangeRecordsCount,
            'timeRangeCompleteCount'  => $timeComplete,
            'timeRangeDraftCount'     => $timeDraft,
            'timeCompletePercentage'  => $timeRangeRecordsCount ? round(($timeComplete / $timeRangeRecordsCount) * 100, 2) : 0,
            'timeDraftPercentage'     => $timeRangeRecordsCount ? round(($timeDraft / $timeRangeRecordsCount) * 100, 2) : 0,
        ]);
    }

    public function getAuditActionPlanByDateRange($startDate, $endDate, $division)
    {
        try {
            $externalAudits = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division);

            $externalNotCompleted = collect($externalAudits)->filter(function ($audit) use ($startDate, $endDate) {
                return $audit->status !== 'complete' &&
                $audit->auditExpiryDate >= $startDate &&
                $audit->auditExpiryDate <= $endDate;
            })->values();

            $externalCompletedWithActionPlans = collect($externalAudits)->filter(function ($audit) {
                return $audit->status === 'complete';
            })->filter(function ($audit) use ($startDate, $endDate) {
                $actionPlans = $this->eaActionPlanInterface->findByExternalAuditId($audit->id);
                return collect($actionPlans)->contains(function ($plan) use ($startDate, $endDate) {
                    return $plan->targetCompletionDate >= $startDate &&
                    $plan->targetCompletionDate <= $endDate;
                });
            })->map(function ($audit) use ($startDate, $endDate) {
                $actionPlans   = $this->eaActionPlanInterface->findByExternalAuditId($audit->id);
                $filteredPlans = collect($actionPlans)->filter(function ($plan) use ($startDate, $endDate) {
                    return $plan->targetCompletionDate >= $startDate &&
                    $plan->targetCompletionDate <= $endDate;
                })->values();

                $audit->action_plans = $filteredPlans;
                return $audit;
            })->values();

            $internalCompletedWithActionPlans = collect(
                $this->internalAuditRecodeInterface->filterByParams($startDate, $endDate, $division)
            )->filter(function ($audit) {
                return $audit->status === 'completed';
            })->filter(function ($audit) use ($startDate, $endDate) {
                $actionPlans = $this->actionPlanInterface->findByInternalAuditId($audit->id);
                return collect($actionPlans)->contains(function ($plan) use ($startDate, $endDate) {
                    return $plan->targetCompletionDate >= $startDate &&
                    $plan->targetCompletionDate <= $endDate;
                });
            })->map(function ($audit) use ($startDate, $endDate) {
                $actionPlans   = $this->actionPlanInterface->findByInternalAuditId($audit->id);
                $filteredPlans = collect($actionPlans)->filter(function ($plan) use ($startDate, $endDate) {
                    return $plan->targetCompletionDate >= $startDate &&
                    $plan->targetCompletionDate <= $endDate;
                })->values();

                $audit->action_plans = $filteredPlans;
                return $audit;
            })->values();

            return response()->json([
                'external_not_completed'               => $externalNotCompleted,
                'external_completed_with_action_plans' => $externalCompletedWithActionPlans,
                'internal_completed_with_action_plans' => $internalCompletedWithActionPlans,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getAuditTypeStats($startDate, $endDate, $division, $type)
    {
        $auditTypes = [];

        if ($type === 'External Audit' || $type === 'both') {
            $externalRecords = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division);

            foreach ($externalRecords as $record) {
                $auditType = $record->auditType ?? 'Unknown';

                if (! isset($auditTypes[$auditType])) {
                    $auditTypes[$auditType] = 0;
                }

                $auditTypes[$auditType]++;
            }
        }

        if ($type === 'Internal Audit' || $type === 'both') {
            $internalRecords = $this->internalAuditRecodeInterface->filterByParams($startDate, $endDate, $division);

            foreach ($internalRecords as $record) {
                $auditType = $record->auditType ?? 'Unknown';

                if (! isset($auditTypes[$auditType])) {
                    $auditTypes[$auditType] = 0;
                }

                $auditTypes[$auditType]++;
            }
        }

        $results = [];
        foreach ($auditTypes as $auditType => $count) {
            $results[] = [
                'auditType' => $auditType,
                'count'     => $count,
            ];
        }

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'type'      => $type,
            'division'  => $division,
            'data'      => $results,
        ]);
    }

    public function getUpcomingExpiryAudit($startDate, $endDate, $division)
    {
        $audits = $this->externalAuditInterface->All()
            ->filter(function ($audit) use ($startDate, $endDate, $division) {
                $expiryDateValid = $audit->auditExpiryDate
                && $audit->auditExpiryDate >= $startDate
                && $audit->auditExpiryDate <= $endDate;

                $notCompleted = ! isset($audit->auditStatus) || strtolower($audit->auditStatus) !== 'completed';

                $divisionMatch = $audit->division === $division;

                return $expiryDateValid && $notCompleted && $divisionMatch;
            })
            ->values()
            ->map(function ($audit) {
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

                $documents = is_string($audit->documents) ? json_decode($audit->documents, true) : (is_array($audit->documents) ? $audit->documents : []);
                foreach ($documents as &$document) {
                    if (isset($document['gsutil_uri'])) {
                        $imageData            = $this->externalAuditService->getImageUrl($document['gsutil_uri']);
                        $document['imageUrl'] = $imageData['signedUrl'];
                        $document['fileName'] = $imageData['fileName'];
                    }
                }
                $audit->documents = $documents;

                $actionPlans       = $this->eaActionPlanInterface->findByExternalAuditId($audit->id);
                $audit->actionPlan = collect($actionPlans)->map(function ($plan) {
                    try {
                        $approver       = $this->userInterface->getById($plan->approverId);
                        $plan->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
                    } catch (\Exception $e) {
                        $plan->approver = ['name' => 'Unknown', 'id' => null];
                    }
                    return $plan;
                });

                return $audit;
            });

        return response()->json($audits, 200);
    }

    public function getCategoryScoreSummary($startDate, $endDate, $division)
    {
        $externalAudits = $this->externalAuditInterface->filterByParams($startDate, $endDate, $division)
            ->filter(function ($audit) {
                return is_numeric($audit->auditScore);
            });

        $grouped = collect($externalAudits)->groupBy(function ($audit) {
            return $audit->auditCategory ?? 'Unknown';
        });

        $results         = [];
        $grandTotalScore = 0;

        foreach ($grouped as $category => $audits) {
            $scoreSum = $audits->sum(function ($audit) {
                return (float) $audit->auditScore;
            });

            $count = $audits->count();

            $results[] = [
                'category'   => $category,
                'count'      => $count,
                'totalScore' => $scoreSum,
                'percentage' => 0,
            ];

            $grandTotalScore += $scoreSum;
        }

        $results = collect($results)->map(function ($item) use ($grandTotalScore) {
            $item['percentage'] = $grandTotalScore > 0
            ? round(($item['totalScore'] / $grandTotalScore) * 100, 2)
            : 0;
            return $item;
        })->all();

        return response()->json([
            'startDate'  => $startDate,
            'endDate'    => $endDate,
            'division'   => $division,
            'TotalScore' => $grandTotalScore,
            'data'       => $results,
        ]);
    }

}
