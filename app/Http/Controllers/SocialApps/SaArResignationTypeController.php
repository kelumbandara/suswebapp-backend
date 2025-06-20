<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaArResignationType\ArResignationTypeRequest;
use App\Repositories\All\SaArResignationType\ArResignationTypeInterface;
use Illuminate\Http\Request;

class SaArResignationTypeController extends Controller
{
      protected $arResignationTypeInterface;

    public function __construct(ArResignationTypeInterface $arResignationTypeInterface)
    {
        $this->arResignationTypeInterface = $arResignationTypeInterface;
    }

    public function index()
    {
        $type = $this->arResignationTypeInterface->All();
        if ($type->isEmpty()) {
            return response()->json([
                'message' => 'No resignation types found.',
            ]);
        }
        return response()->json($type);
    }

    public function store(ArResignationTypeRequest $request)
    {
        $type = $this->arResignationTypeInterface->create($request->validated());

        return response()->json([
            'message'  => 'Resignation type created successfully!',
            'type' => $type,
        ], 201);
    }
}
