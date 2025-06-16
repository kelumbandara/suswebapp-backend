<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaGrTopic\GrTopicRequest;
use App\Repositories\All\SaGrTopic\GrTopicInterface;

class SaGrTopicController extends Controller
{
    protected $grTopicInterface;

    public function __construct(GrTopicInterface $grTopicInterface)
    {
        $this->grTopicInterface = $grTopicInterface;
    }

    public function index()
    {
        $topic = $this->grTopicInterface->All();
        if ($topic->isEmpty()) {
            return response()->json([
                'message' => 'No topic found.',
            ]);
        }
        return response()->json($topic);
    }

    public function store(GrTopicRequest $request)
    {
        $topic = $this->grTopicInterface->create($request->validated());

        return response()->json([
            'message'  => 'Topic created successfully!',
            'topic' => $topic,
        ], 201);
    }
}
