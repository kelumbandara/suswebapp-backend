<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaSrImpactType\ImpactTypeRequest;
use App\Repositories\All\SaSrImpactType\ImpactTypeInterface;

class SaSrIdImpactTypeController extends Controller
{
    protected $impactTypeInterface;

    public function __construct(ImpactTypeInterface $impactTypeInterface)
    {
        $this->impactTypeInterface = $impactTypeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $impactType = $this->impactTypeInterface->all();
        return response()->json($impactType);
    }

    public function store(ImpactTypeRequest $request)
    {
        $data       = $request->validated();
        $impactType = $this->impactTypeInterface->create($data);
        return response()->json([
            'message' => 'Impact Type created successfully',
            'data'    => $impactType,
        ], 201);
    }

    public function getImpactType()
    {
        $type = $this->impactTypeInterface->all(['id', 'impactType']);

        $uniqueTypes = $type->groupBy('impactType')->map(function ($item) {
            return $item->first();
        })->values();

        if ($uniqueTypes->isEmpty()) {
            return response()->json([
                'message' => 'No type found.',
            ]);
        }

        return response()->json($uniqueTypes);
    }

    public function getImpactUnit($impactType)
    {
        $subTypes = $this->impactTypeInterface->getByColumn(['impactType' => $impactType], ['id', 'impactUnit']);

        if ($subTypes->isEmpty()) {
            return response()->json([
                'message' => 'No Impact Unit found.',
            ]);
        }


        $uniqueSubUnits = $subTypes->unique('impactUnit')->values()->map(function ($item) {
            return [
                'id'          => (int) $item->id,
                'impactUnit' => $item->impactUnit,
            ];
        });

        return response()->json($uniqueSubUnits);
    }
}
