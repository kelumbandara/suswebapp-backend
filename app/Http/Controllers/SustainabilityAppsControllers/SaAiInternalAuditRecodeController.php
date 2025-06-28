<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIarActionPlane\ActionPlaneRequest;
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
        try {
            $internalAudits = $this->internalAuditRecodeInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

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
                        $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

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
            }

            return response()->json($internalAudits, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $audit = $this->internalAuditRecodeInterface->getById($id);

            if (! $audit) {
                return response()->json(['message' => 'Internal Audit record not found'], 404);
            }

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
                    $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

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

            $audit->actionPlan = $this->actionPlanInterface->findByInternalAuditId($audit->id);
            $audit->answers    = $this->answerRecodeInterface->findByInternalAuditId($audit->id);

            return response()->json($audit, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function getFinalAuditers()
    {
        try {
            $internalAudits = $this->internalAuditRecodeInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

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
                        $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

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
        $validatedData['status']      = 'scheduled';

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

        $updatedRecord          = $this->internalAuditRecodeInterface->findById($id);
        $updatedRecord->answers = $this->answerRecodeInterface->findByInternalAuditId($id);

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
        $validatedData['status']      = 'completed';

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

    public function actionPlanUpdate($id, ActionPlaneRequest $request)
    {
        $data = $request->validated();

        $updatedActionPlan = $this->actionPlanInterface->update($id, $data);

        return response()->json([
            'message' => 'Action plan updated successfully',
            'data'    => $updatedActionPlan,
        ], 200);
    }

    public function actionPlanStore(ActionPlaneRequest $request)
    {
        $data       = $request->validated();
        $actionplan = $this->actionPlanInterface->create($data);
        return response()->json([
            'message' => 'Action plan created successfully',
            'data'    => $actionplan,
        ], 201);

    }

    public function actionPlanDelete($id)
    {
        $actionplan = $this->actionPlanInterface->deleteById($id);
        return response()->json([
            'message' => $actionplan ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $actionplan ? 200 : 500);

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
        try {
            $audit = $this->internalAuditRecodeInterface->getById($id);

            if (! $audit) {
                return response()->json(['message' => 'Internal Audit record not found'], 404);
            }

            $this->actionPlanInterface->deleteByInternalAuditId($id);

            $this->answerRecodeInterface->deleteByInternalAuditId($id);

            $this->internalAuditRecodeInterface->deleteById($id);

            return response()->json(['message' => 'Internal Audit record and related data deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function assignTask()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $internalAudits = $this->internalAuditRecodeInterface->getByApproverId($user->id)
                ->filter(function ($risk) {
                    return $risk->status !== 'Approved';
                })
                ->sortByDesc('created_at')->sortByDesc('updated_at')->values();

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
                        $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

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

                try {
                    $actionPlans       = $this->actionPlanInterface->findByInternalAuditId($audit->id);
                    $audit->actionPlan = collect($actionPlans)->map(function ($actionPlan) {
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
                } catch (\Exception $e) {
                    $audit->actionPlan = [];
                }

                try {
                    $audit->answers = $this->answerRecodeInterface->findByInternalAuditId($audit->id);
                } catch (\Exception $e) {
                    $audit->answers = [];
                }

                return $audit;
            });

            return response()->json($internalAudits, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function assignTaskApproved()
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $internalAudits = $this->internalAuditRecodeInterface->getByApproverId($user->id)
                ->filter(function ($med) {
                    return $med->status === 'approved';
                })
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
                        $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

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

                try {
                    $actionPlans       = $this->actionPlanInterface->findByInternalAuditId($audit->id);
                    $audit->actionPlan = collect($actionPlans)->map(function ($actionPlan) {
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
                } catch (\Exception $e) {
                    $audit->actionPlan = [];
                }

                try {
                    $audit->answers = $this->answerRecodeInterface->findByInternalAuditId($audit->id);
                } catch (\Exception $e) {
                    $audit->answers = [];
                }

                return $audit;
            });

            return response()->json($internalAudits, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatusToApproved(string $id)
    {
        $user = Auth::user();

        if (! $user || $user->assigneeLevel != 5) {
            return response()->json([
                'message' => 'Unauthorized. Only CEO assignees can approve.',
            ], 403);
        }

        $record = $this->internalAuditRecodeInterface->findById($id);

        if (! $record) {
            return response()->json([
                'message' => 'Internal audit record not found.',
            ], 404);
        }

        $updated = $this->internalAuditRecodeInterface->update($id, [
            'status' => 'Approved',
        ]);

        if (! $updated) {
            return response()->json([
                'message' => 'Failed to approve the internal audit record.',
            ], 500);
        }

        $record = $this->internalAuditRecodeInterface->findById($id);

        return response()->json([
            'message' => 'Internal audit record approved successfully!',
            'record'  => $record,
        ], 200);
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

    public function getStatusCountByMonth($year, $division)
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

            $records = $this->internalAuditRecodeInterface->filterByYearMonthDivision($year, $month, $division);

            foreach ($records as $record) {
                $status = strtolower(trim($record->status ?? 'unknown'));

                if (! isset($statusSummary[$status])) {
                    $statusSummary[$status] = 0;
                }

                $statusSummary[$status]++;
            }

            $monthlyStatusCounts[$monthNames[$month]] = $statusSummary;
        }

        return response()->json([
            'year'     => (int) $year,
            'division' => $division,
            'data'     => $monthlyStatusCounts,
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
            $audits  = $this->internalAuditRecodeInterface->filterByYearMonthDivision($year, $month, $division);
            $results = [];

            foreach ($audits as $audit) {
                try {
                    $questionRecode = $this->questionRecodeInterface->getById($audit->auditId);
                    if (! $questionRecode) {
                        continue;
                    }

                    $answers    = $this->answerRecodeInterface->findByInternalAuditId($audit->id);
                    $totalScore = collect($answers)->sum('score');

                    $results[] = [
                        'internalAuditId' => $audit->id,
                        'auditId'         => $audit->auditId,
                        'totalScore'      => $totalScore,
                        'questionRecode'  => $questionRecode,
                    ];
                } catch (\Exception $e) {
                    continue;
                }
            }

            $monthlyAuditScores[$monthNames[$month]] = $results;
        }

        return response()->json([
            'year'     => (int) $year,
            'division' => $division,
            'data'     => $monthlyAuditScores,
        ]);
    }

}
