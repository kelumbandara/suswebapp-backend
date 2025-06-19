<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrState\RrStateRequest;
use App\Repositories\All\SaRrState\RrStateInterface;

class SaRrStateController extends Controller
{
    protected $rrStateInterface;

    public function __construct(RrStateInterface $rrStateInterface)
    {
        $this->rrStateInterface = $rrStateInterface;
    }

    public function index($countryId)
    {
        $states = $this->rrStateInterface->findByCountryId($countryId);

        if ($states->isEmpty()) {
            return response()->json();
        }

        return response()->json($states);
    }

    public function store(RrStateRequest $request)
    {
        $state = $this->rrStateInterface->create($request->validated());

        return response()->json([
            'message' => 'State created successfully!',
            'state'   => $state,
        ], 201);
    }
}
