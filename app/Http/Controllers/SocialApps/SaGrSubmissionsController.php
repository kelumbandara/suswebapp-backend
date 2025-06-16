<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaGrSubmission\GrSubmissionRequest;
use App\Repositories\All\SaGrSubmissions\GrSubmissionsInterface;

class SaGrSubmissionsController extends Controller
{
    protected $grSubmissionsInterface;

    public function __construct(GrSubmissionsInterface $grSubmissionsInterface)
    {
        $this->grSubmissionsInterface = $grSubmissionsInterface;
    }

    public function index()
    {
        $submission = $this->grSubmissionsInterface->All();
        if ($submission->isEmpty()) {
            return response()->json([
                'message' => 'No submission found.',
            ]);
        }
        return response()->json($submission);
    }

    public function store(GrSubmissionRequest $request)
    {
        $submission = $this->grSubmissionsInterface->create($request->validated());

        return response()->json([
            'message'  => 'Submission created successfully!',
            'submission' => $submission,
        ], 201);
    }
}
