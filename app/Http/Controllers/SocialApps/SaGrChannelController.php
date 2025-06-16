<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaGrChannel\GrChannelRequest;
use App\Repositories\All\SaGrChannel\GrChannelInterface;

class SaGrChannelController extends Controller
{
    protected $grChannelInterface;

    public function __construct(GrChannelInterface $grChannelInterface)
    {
        $this->grChannelInterface = $grChannelInterface;
    }

    public function index()
    {
        $channel = $this->grChannelInterface->All();
        if ($channel->isEmpty()) {
            return response()->json([
                'message' => 'No channel found.',
            ]);
        }
        return response()->json($channel);
    }

    public function store(GrChannelRequest $request)
    {
        $channel = $this->grChannelInterface->create($request->validated());

        return response()->json([
            'message'  => 'Channel created successfully!',
            'channel' => $channel,
        ], 201);
    }
}
