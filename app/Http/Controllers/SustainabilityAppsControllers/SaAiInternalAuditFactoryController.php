<?php
namespace App\Http\Controllers\SustainabilityAppsControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAiInternalAuditFactory\InternalAuditFactoryRequest;
use App\Repositories\All\SaAiIaContactPerson\ContactPersonInterface;
use App\Repositories\All\SaAiInternalAuditFactory\InternalAuditFactoryInterface;

class SaAiInternalAuditFactoryController extends Controller
{
    protected $internalAuditFactoryInterface;
    protected $contactPersonInterface;

    public function __construct(InternalAuditFactoryInterface $internalAuditFactoryInterface, ContactPersonInterface $contactPersonInterface)
    {
        $this->internalAuditFactoryInterface = $internalAuditFactoryInterface;
        $this->contactPersonInterface        = $contactPersonInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $factories = $this->internalAuditFactoryInterface->all();

        $result = $factories->map(function ($factory) {
            try {
                $contactPerson = $this->contactPersonInterface->getById($factory->factoryContactPerson);
                $factory->factoryContactPerson = $contactPerson
                    ? ['name' => $contactPerson->name, 'id' => $contactPerson->id]
                    : ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $factory->factoryContactPerson = ['name' => 'Unknown', 'id' => null];
            }

            return $factory;
        });

        return response()->json($result);
    }


    public function store(InternalAuditFactoryRequest $request)
    {
        $data    = $request->validated();
        $factory = $this->internalAuditFactoryInterface->create($data);
        return response()->json([
            'message' => 'Audit Factory created successfully',
            'data'    => $factory,
        ], 201);
    }
}
