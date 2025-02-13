<?php

namespace App\Http\Controllers\CommonControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResponsibleSection\ResponsibleSectionRequest;
use App\Repositories\All\ComResponsibleSection\ComResponsibleSectionInterface;
use Illuminate\Http\Request;

class ResponsibleSectionController extends Controller
{
    protected $comResponsibleSectionInterface;

    public function __construct(ComResponsibleSectionInterface $comResponsibleSectionInterface)
    {
        $this->comResponsibleSectionInterface = $comResponsibleSectionInterface;
    }

    public function index()
    {
        $responsibleSection = $this->comResponsibleSectionInterface->All();
        if ($responsibleSection->isEmpty()) {
            return response()->json([
                'message' => 'No Responsible Section found.',
            ]);
        }
        return response()->json($responsibleSection);
    }

    public function store(ResponsibleSectionRequest $request)
    {
        $responsibleSection = $this->comResponsibleSectionInterface->create($request->validated());

        return response()->json([
            'message'    => 'Responsible Section created successfully!',
            'responsibleSection' => $responsibleSection,
        ], 201);
    }
}
