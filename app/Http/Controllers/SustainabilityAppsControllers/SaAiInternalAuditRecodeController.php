<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiInternalAuditRecode\InternalAuditRequest;
use App\Repositories\All\ComDepartment\DepartmentInterface;
use App\Repositories\All\SaAiIaActionPlan\ActionPlanInterface;
use App\Repositories\All\SaAiIaAnswerRecode\AnswerRecodeInterface;
use App\Repositories\All\SaAiIaAuditTitle\AuditTitleInterface;
use App\Repositories\All\SaAiIaContactPerson\ContactPersonInterface;
use App\Repositories\All\SaAiIaQrGroupRecode\GroupRecodeInterface;
use App\Repositories\All\SaAiIaQrQuection\QuestionsInterface;
use App\Repositories\All\SaAiIaQuestionRecode\QuestionRecodeInterface;
use App\Repositories\All\SaAiInternalAuditRecode\InternalAuditRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class SaAiInternalAuditRecodeController extends Controller
{

    protected $internalAuditRecodeInterface;
    protected $userInterface;
    protected $actionPlanInterface;
    protected $answerRecodeInterface;
    protected $contactPersonInterface;
    protected $departmentInterface;
    protected $auditTitleInterface;
    protected $questionRecodeInterface;
    protected $questionsInterface;
    protected $groupRecodeInterface;

    public function __construct(InternalAuditRecodeInterface $internalAuditRecodeInterface, DepartmentInterface $departmentInterface, UserInterface $userInterface, ActionPlanInterface $actionPlanInterface, AnswerRecodeInterface $answerRecodeInterface, ContactPersonInterface $contactPersonInterface, AuditTitleInterface $auditTitleInterface, QuestionRecodeInterface $questionRecodeInterface, QuestionsInterface $questionsInterface, GroupRecodeInterface $groupRecodeInterface)
    {
        $this->internalAuditRecodeInterface = $internalAuditRecodeInterface;
        $this->userInterface                = $userInterface;
        $this->actionPlanInterface          = $actionPlanInterface;
        $this->answerRecodeInterface        = $answerRecodeInterface;
        $this->contactPersonInterface       = $contactPersonInterface;
        $this->departmentInterface          = $departmentInterface;
        $this->auditTitleInterface          = $auditTitleInterface;
        $this->questionRecodeInterface      = $questionRecodeInterface;
        $this->questionsInterface           = $questionsInterface;
        $this->groupRecodeInterface         = $groupRecodeInterface;
    }

    public function index()
    {
        $internalAudit = $this->internalAuditRecodeInterface->All();

        $internalAudit = $internalAudit->map(function ($audit) {
            try {
                $approver = $this->userInterface->getById($audit->approverId);
                $audit->approver = $approver ? ['name' => $approver->name, 'id' => $approver->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->approver = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $auditee = $this->userInterface->getById($audit->auditeeId);
                $audit->auditee = $auditee ? ['name' => $auditee->name, 'id' => $auditee->id] : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->auditee = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $creator = $this->userInterface->getById($audit->createdByUser);
                $audit->createdByUserName = $creator ? $creator->name : 'Unknown';
            } catch (\Exception $e) {
                $audit->createdByUserName = 'Unknown';
            }

            try {
                $contactPerson = $this->contactPersonInterface->getById($audit->factoryContactPersonId);
                $audit->factoryContactPerson = $contactPerson
                    ? ['name' => $contactPerson->name, 'id' => $contactPerson->id]
                    : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $audit->factoryContactPerson = ['name' => 'Unknown', 'id' => null];
            }

            try {
                $questionRecode = $this->questionRecodeInterface->getById($audit->auditId);

                $totalQuestions = 0;
                $totalScore = 0;

                $groups = $this->groupRecodeInterface->findByQuestionRecoId($questionRecode->id);

                $groups = collect($groups)->map(function ($group) use (&$totalQuestions, &$totalScore) {
                    $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

                    $group->questions = $questions;

                    $totalQuestions += count($questions);
                    $totalScore += collect($questions)->sum('allocatedScore');

                    return $group;
                });

                $questionRecode->questionGroups = $groups;
                $questionRecode->totalNumberOfQuestions = $totalQuestions;
                $questionRecode->achievableScore = $totalScore;

                $audit->audit = $questionRecode;

            } catch (\Exception $e) {
                $audit->audit = null;
            }

            try {
                $departments = [];
                if (is_array($audit->department)) {
                    foreach ($audit->department as $dept) {
                        $deptId = is_array($dept) && isset($dept['id']) ? $dept['id'] : $dept;
                        $department = $this->departmentInterface->getById($deptId);
                        $departments[] = $department
                            ? ['department' => $department->department, 'id' => $department->id]
                            : ['department' => 'Unknown', 'id' => $deptId];
                    }
                }
                $audit->department = $departments;
            } catch (\Exception $e) {
                $audit->department = [['department' => 'Unknown', 'id' => null]];
            }

            return $audit;
        });

        foreach ($internalAudit as $audit) {
            $audit->actionPlan = $this->actionPlanInterface->findByInternalAuditId($audit->id);
        }

        return response()->json($internalAudit->values());
    }


    public function getFinalAuditers()
    {
        try {
            $internalAudits = $this->internalAuditRecodeInterface->All();

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
                    $totalScore = 0;

                    $groups = $this->groupRecodeInterface->findByQuestionRecoId($questionRecode->id);

                    $groups = collect($groups)->map(function ($group) use (&$totalQuestions, &$totalScore) {
                        $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

                        $group->questions = $questions;

                        $totalQuestions += count($questions);
                        $totalScore += collect($questions)->sum('allocatedScore');

                        return $group;
                    });

                    $questionRecode->questionGroups = $groups;
                    $questionRecode->totalNumberOfQuestions = $totalQuestions;
                    $questionRecode->achievableScore = $totalScore;

                    $audit->audit = $questionRecode;

                } catch (\Exception $e) {
                    $audit->audit = null;
                }

                try {
                    $departments = [];
                    if (is_array($audit->department)) {
                        foreach ($audit->department as $dept) {
                            $deptId = is_array($dept) && isset($dept['id']) ? $dept['id'] : $dept;

                            $department = $this->departmentInterface->getById($deptId);

                            $departments[] = $department
                                ? ['department' => $department->department, 'id' => $department->id]
                                : ['department' => 'Unknown', 'id' => $deptId];
                        }
                    }
                    $audit->department = $departments;
                } catch (\Exception $e) {
                    $audit->department = [['department' => 'Unknown', 'id' => null]];
                }

                return $audit;
            });

            foreach ($internalAudits as $audit) {
                $audit->actionPlan = $this->actionPlanInterface->findByInternalAuditId($audit->id);
                $audit->answers    = $this->answerRecodeInterface->findByInternalAuditId($audit->id);
            }

            return response()->json([
                'message' => 'Internal audits fetched successfully.',
                'data'    => $internalAudits,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(InternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;

        $internalAudit = $this->internalAuditRecodeInterface->create($validatedData);

        if (! $internalAudit) {
            return response()->json(['message' => 'Failed to create internal audit record'], 500);
        }
        return response()->json([
            'message'       => 'Internal audit record created successfully!',
            'internalAudit' => $internalAudit,
        ], 201);
    }

    public function saveDraft(InternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $validatedData['draftBy'] = $userId;
        $validatedData['status']  = 'draft';

        $internalAudit = $this->internalAuditRecodeInterface->create($validatedData);

        if (! $internalAudit) {
            return response()->json(['message' => 'Failed to save draft'], 500);
        }

        return response()->json([
            'message'       => 'Draft saved successfully!',
            'internalAudit' => $internalAudit,
        ], 201);
    }

    public function updateDraft(InternalAuditRequest $request, $id)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $draft = $this->internalAuditRecodeInterface->findById($id);


        $validatedData['draftBy'] = $userId;
        $validatedData['status']  = 'draft';

        $updatedDraft = $this->internalAuditRecodeInterface->update($id, $validatedData);

        if (! $updatedDraft) {
            return response()->json(['message' => 'Failed to update draft'], 500);
        }

        return response()->json([
            'message'       => 'Draft updated successfully!',
            'internalAudit' => $updatedDraft,
        ]);
    }

    public function shedualedUpdate(InternalAuditRequest $request, $id)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $shedualed = $this->internalAuditRecodeInterface->findById($id);


        $validatedData['scheduledBy'] = $userId;
        $validatedData['status']  = 'scheduled';

        $updatedShedualed = $this->internalAuditRecodeInterface->update($id, $validatedData);

        if (! $updatedShedualed) {
            return response()->json(['message' => 'Failed to update shedualed'], 500);
        }

        return response()->json([
            'message'       => 'Shedualed updated successfully!',
            'internalAudit' => $updatedShedualed,
        ]);
    }

    public function saveSchedualed(InternalAuditRequest $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $validatedData['scheduledBy'] = $userId;
        $validatedData['status']      = 'scheduled';

        $internalAudit = $this->internalAuditRecodeInterface->create($validatedData);

        if (! $internalAudit) {
            return response()->json(['message' => 'Failed to save shedualed'], 500);
        }

        return response()->json([
            'message'       => 'Scheduled saved successfully!',
            'internalAudit' => $internalAudit,
        ], 201);
    }

    public function updateOngoing(InternalAuditRequest $request, $id)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $validatedData['ongoingBy'] = $userId;
        $validatedData['status']    = 'ongoing';

        $record = $this->internalAuditRecodeInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $updateSuccess = $this->internalAuditRecodeInterface->update($id, $validatedData);
        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update internal audit'], 500);
        }

        $this->answerRecodeInterface->deleteByInternalAuditId($id);

        if (! empty($validatedData['answers'])) {
            foreach ($validatedData['answers'] as $answer) {
                $answer['internalAuditId'] = $id;
                $this->answerRecodeInterface->create($answer);
            }
        }

        $updatedRecord                = $this->internalAuditRecodeInterface->findById($id);
        $updatedRecord->impactDetails = $this->answerRecodeInterface->findByInternalAuditId($id);

        return response()->json([
            'message'       => 'Ongoing audit updated successfully!',
            'internalAudit' => $updatedRecord,
        ], 200);
    }

    public function complete(InternalAuditRequest $request, $id)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId        = $user->id;
        $validatedData = $request->validated();

        $validatedData['completedBy'] = $userId;
        $validatedData['status']      = 'completedBy';

        $record = $this->internalAuditRecodeInterface->findById($id);
        if (! $record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $updateSuccess = $this->internalAuditRecodeInterface->update($id, $validatedData);
        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update internal audit'], 500);
        }

        $this->answerRecodeInterface->deleteByInternalAuditId($id);

        if (! empty($validatedData['answers'])) {
            foreach ($validatedData['answers'] as $answer) {
                $answer['internalAuditId'] = $id;
                $this->answerRecodeInterface->create($answer);
            }
        }

        $updatedRecord                = $this->internalAuditRecodeInterface->findById($id);
        $updatedRecord->impactDetails = $this->answerRecodeInterface->findByInternalAuditId($id);

        return response()->json([
            'message'       => 'Ongoing audit updated successfully!',
            'internalAudit' => $updatedRecord,
        ], 200);
    }

    public function actionPlanUpdate($id, InternalAuditRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $internalAudit = $this->internalAuditRecodeInterface->findById($id);
        if (! $internalAudit) {
            return response()->json(['message' => 'Internal audit record not found.'], 404);
        }

        $validatedData                = $request->validated();
        $validatedData['completedBy'] = $user->id;

        $updated = $this->internalAuditRecodeInterface->update($id, $validatedData);
        if (! $updated) {
            return response()->json(['message' => 'Failed to update internal audit record'], 500);
        }

        $this->answerRecodeInterface->deleteByInternalAuditId($id);
        if (! empty($validatedData['answers'])) {
            foreach ($validatedData['answers'] as $answer) {
                $answer['internalAuditId'] = $id;
                $this->answerRecodeInterface->create($answer);
            }
        }

        $this->actionPlanInterface->deleteByInternalAuditId($id);
        if (! empty($validatedData['actionPlans'])) {
            foreach ($validatedData['actionPlans'] as $actionPlan) {
                $actionPlan['internalAuditId'] = $id;
                $this->actionPlanInterface->create($actionPlan);
            }
        }

        $updatedRecord              = $this->internalAuditRecodeInterface->findById($id);
        $updatedRecord->answers     = $this->answerRecodeInterface->findByInternalAuditId($id);
        $updatedRecord->actionPlans = $this->actionPlanInterface->findByInternalAuditId($id);

        return response()->json([
            'message'       => 'Action plan and audit updated successfully!',
            'internalAudit' => $updatedRecord,
        ], 200);
    }

    public function update($id, InternalAuditRequest $request)
    {
        $internalAudit = $this->internalAuditRecodeInterface->findById($id);

        if (! $internalAudit) {
            return response()->json(['message' => 'Internal audit record not found.'], 404);
        }

        $validatedData = $request->validated();

        $updated = $internalAudit->update($validatedData);

        if ($updated) {
            return response()->json([
                'message'       => 'Internal audit record updated successfully!',
                'externalAudit' => $this->internalAuditRecodeInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the internal audit record.'], 500);
        }
    }

    public function destroy($id)
    {
        $internalAudit = $this->internalAuditRecodeInterface->findById((int) $id);

        $deleted = $this->internalAuditRecodeInterface->deleteById($id);

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

        $internalAudit = $this->internalAuditRecodeInterface->getByApproverId($user->id);

        $internalAudit = $internalAudit->map(function ($audit) {
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
                $departments = [];
                if (is_array($audit->department)) {
                    foreach ($audit->department as $dept) {
                        $deptId = is_array($dept) && isset($dept['id']) ? $dept['id'] : $dept;

                        $department = $this->departmentInterface->getById($deptId);

                        $departments[] = $department
                            ? ['department' => $department->department, 'id' => $department->id]
                            : ['department' => 'Unknown', 'id' => $deptId];
                    }
                }
                $audit->department = $departments;
            } catch (\Exception $e) {
                $audit->department = [['department' => 'Unknown', 'id' => null]];
            }
            return $audit;
        });

        return response()->json($internalAudit, 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Internal Audit Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }
}
