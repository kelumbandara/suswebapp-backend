<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRrSourceOfHirng\RrSourceOfHirngRequest;
use App\Repositories\All\SaRrSourceOfHiring\RrSourceOfHiringInterface;
use Illuminate\Http\Request;

class SaRrSourceOfHirngController extends Controller
{
    protected $rrSourceOfHiringInterface;

    public function __construct(RrSourceOfHiringInterface $rrSourceOfHiringInterface)
    {
        $this->rrSourceOfHiringInterface = $rrSourceOfHiringInterface;
    }

    public function index()
    {
        $source = $this->rrSourceOfHiringInterface->All();
        if ($source->isEmpty()) {
            return response()->json([
                'message' => 'No Source Of Hiring found.',
            ]);
        }
        return response()->json($source);
    }

    public function store(RrSourceOfHirngRequest $request)
    {
        $source = $this->rrSourceOfHiringInterface->create($request->validated());

        return response()->json([
            'message'  => 'Source Of Hiring created successfully!',
            'source of hiring' => $source,
        ], 201);
    }
}
