<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaQuestionRecode\QuestionRecodeRequest;
use App\Repositories\All\SaAiIaQrGroupRecode\GroupRecodeInterface;
use App\Repositories\All\SaAiIaQrQuection\QuestionsInterface;
use App\Repositories\All\SaAiIaQuestionRecode\QuestionRecodeInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class SaAiIaQuestionRecodeController extends Controller
{
    protected $questionRecodeInterface;
    protected $questionsInterface;
    protected $groupRecodeInterface;
    protected $userInterface;


    public function __construct(QuestionRecodeInterface $questionRecodeInterface, UserInterface $userInterface, QuestionsInterface $questionsInterface, GroupRecodeInterface $groupRecodeInterface)
    {
        $this->questionRecodeInterface = $questionRecodeInterface;
        $this->questionsInterface      = $questionsInterface;
        $this->groupRecodeInterface    = $groupRecodeInterface;
        $this->userInterface           = $userInterface;
    }

    public function index()
    {
        $records = $this->questionRecodeInterface->All();

        $records = $records->map(function ($record) {
            $totalQuestions = 0;
            $totalScore = 0;

            $groups = $this->groupRecodeInterface->findByQuestionRecoId($record->id);

            $groups = collect($groups)->map(function ($group) use (&$totalQuestions, &$totalScore) {
                $questions = $this->questionsInterface->findByQueGroupId($group->queGroupId);

                $group->questions = $questions;

                $totalQuestions += count($questions);
                $totalScore += collect($questions)->sum('allocatedScore');

                return $group;
            });

            $record->questionGroups = $groups;
            $record->totalNumberOfQuestions = $totalQuestions;
            $record->achievableScore = $totalScore;

            return $record;
        });

        return response()->json($records, 200);
    }



    public function store(QuestionRecodeRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validated();
        $data['createdByUser'] = $user->id;

        $record = $this->questionRecodeInterface->create($data);

        if (! $record) {
            return response()->json(['message' => 'Failed to create Internal audit Question report'], 500);
        }

        foreach ($data['questionGroups'] as $group) {
            $groupData = [
                'questionRecoId' => $record->id,
                'groupName'      => $group['groupName'],
            ];

            $savedGroup = $this->groupRecodeInterface->create($groupData);

            if ($savedGroup && ! empty($group['questions'])) {
                foreach ($group['questions'] as $question) {
                    $questionData = [
                        'queGroupId'     => $savedGroup->queGroupId,
                        'questionRecoId' => $record->id,
                        'colorCode'      => $question['colorCode'],
                        'question'       => $question['question'],
                        'allocatedScore' => $question['allocatedScore'],
                    ];

                    $this->questionsInterface->create($questionData);
                }
            }
        }

        return response()->json([
            'message' => 'Internal audit Question report created successfully',
            'record'  => $record,
        ], 201);
    }


    public function update(QuestionRecodeRequest $request, string $id)
    {
        $data   = $request->validated();
        $record = $this->questionRecodeInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Internal audit Question report not found'], 404);
        }

        $updateSuccess = $record->update($data);
        if (! $updateSuccess) {
            return response()->json(['message' => 'Failed to update Internal audit Question report'], 500);
        }

        $this->groupRecodeInterface->deleteByQuestionRecoId($id);
        $this->questionsInterface->deleteByQuestionRecoId($id);

        if (! empty($data['questionGroups'])) {
            foreach ($data['questionGroups'] as $questionGroups) {
                $questionGroups['questionRecoId'] = $record->id;
                $savedGroup                    = $this->groupRecodeInterface->create($questionGroups);

                if (! empty($questionGroups['questions'])) {
                    foreach ($questionGroups['questions'] as $questions) {
                        $questions['queGroupId']     = $savedGroup->queGroupId;
                        $questions['questionRecoId'] = $record->id;
                        $this->questionsInterface->create($questions);
                    }
                }
            }
        }

        $updatedRecord                 = $this->questionRecodeInterface->findById($id);
        $updatedRecord->questionGroups    = $this->groupRecodeInterface->findByQuestionRecoId($id);
        $updatedRecord->questions = $this->questionsInterface->findByQuestionRecoId($id);

        return response()->json([
            'message' => 'Internal audit Question report updated successfully',
            'record'  => $updatedRecord,
        ], 200);
    }

    public function destroy(string $id)
    {
        $record = $this->questionRecodeInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Internal audit Question report not found'], 404);
        }

        $this->groupRecodeInterface->deleteByQuestionRecoId($id);
        $this->questionsInterface->deleteByQuestionRecoId($id);

        $this->questionRecodeInterface->deleteById($id);

        return response()->json(['message' => 'Internal audit Question report deleted successfully'], 200);
    }

    public function assignee()
    {
        $user        = Auth::user();
        $targetLevel = $user->assigneeLevel + 1;

        $assignees = $this->userInterface->getUsersByAssigneeLevelAndSection($targetLevel, 'Internal Question Section')
            ->where('availability', 1)
            ->values();

        return response()->json($assignees);
    }

}
