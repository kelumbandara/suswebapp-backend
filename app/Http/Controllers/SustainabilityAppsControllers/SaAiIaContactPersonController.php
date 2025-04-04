<?php

namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiIaContactPerson\ContactPersonRequest;
use App\Repositories\All\SaAiIaContactPerson\ContactPersonInterface;

class SaAiIaContactPersonController extends Controller
{
    protected $contactPersonInterface;

    public function __construct(ContactPersonInterface $contactPersonInterface)
    {
        $this->contactPersonInterface = $contactPersonInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = $this->contactPersonInterface->all();
        return response()->json($person);
    }

    public function store(ContactPersonRequest $request)
    {
        $data = $request->validated();
        $person  = $this->contactPersonInterface->create($data);
        return response()->json([
            'message' => 'Contact Person created successfully',
            'data'    => $person,
        ], 201);
    }
}
