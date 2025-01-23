<?php

namespace App\Http\Controllers\SustainabilityApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SustainabilityApps\ExternalAuditsRequest;
use App\Repositories\All\SAExternalAudits\ExternalAuditInterface;

class ExternalAuditController extends Controller
{
    protected ExternalAuditInterface $externalAuditInterface;

    public function __construct(ExternalAuditInterface $externalAuditInterface)
    {
        $this->externalAuditInterface = $externalAuditInterface;
    }

    public function index()
    {
        $audits = $this->externalAuditInterface->all();

        return response()->json($audits);
    }

    public function store(ExternalAuditsRequest $request)
    {
        $data = $request->validated();

        $data['referenceNumber'] = 'AUD-' . strtoupper(uniqid());

        $audit = $this->externalAuditInterface->create($data);

        return response()->json([
            'message' => 'External Audit created successfully!',
            'audit' => $audit,
        ], 201);
    }

    public function show($id)
    {
        $audit = $this->externalAuditInterface->getById($id);

        return response()->json($audit);
    }


    public function update(ExternalAuditsRequest $request, $id)
    {
        $data = $request->validated();

        $audit = $this->externalAuditInterface->update($id, $data);

        return response()->json([
            'message' => 'External Audit updated successfully!',
            'audit' => $audit,
        ]);
    }

    public function destroy($id)
    {
        $this->externalAuditInterface->deleteById($id);

        return response()->json([
            'message' => 'External Audit deleted successfully!',
        ]);
    }
}
