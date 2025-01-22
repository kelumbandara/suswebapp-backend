<?php

namespace App\Http\Controllers\SustainabilityApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SustainabilityApps\InternalAuditsRequest;
use App\Repositories\All\SAInternalAudits\InternalAuditInterface;
use Illuminate\Http\Request;

class InternalAuditController extends Controller
{
    protected InternalAuditInterface $InternalAuditInterface;

    public function __construct(InternalAuditInterface $documentInterface)
    {
        $this->InternalAuditInterface = $documentInterface;
    }

    public function index()
    {
        $audits = $this->InternalAuditInterface->All();
        return response()->json($audits);
    }

    /**
     * Store a newly created internal audit in storage.
     */
    public function store(InternalAuditsRequest $request)
    {
        $data = $request->validated();
        if ($data['isNotSupplier']) {
            $data['supplierType'] = $request->input('supplierType');
            $data['factoryLiNo'] = $request->input('factoryLiNo');
            $data['higgId'] = $request->input('higgId');
            $data['zdhcId'] = $request->input('zdhcId');
            $data['processType'] = $request->input('processType');
        }
        $data['referenceNumber'] = 'AUD-' . strtoupper(uniqid());
        $audit = $this->InternalAuditInterface->create($data);

        return response()->json([
            'message' => 'Internal Audit created successfully!',
            'audit' => $audit,
        ], 201);
    }

    /**
     * Display the specified internal audit.
     */
    public function show($id)
    {
        $audit = $this->InternalAuditInterface->getById($id);
        if ($audit->is_supplier_audit) {
            return response()->json([
                'audit' => $audit,
                'supplierDetails' => [
                    'supplierType' => $audit->supplierType,
                    'factoryLiNo' => $audit->factoryLiNo,
                    'higgId' => $audit->higgId,
                    'zdhcId' => $audit->zdhcId,
                    'processType' => $audit->processType,
                ]
            ]);
        }
        return response()->json($audit);
    }

    /**
     * Update the specified internal audit in storage.
     */
    public function update(InternalAuditsRequest $request, $id)
    {
        $data = $request->validated();
        $audit = $this->InternalAuditInterface->update($id, $data);

        return response()->json([
            'message' => 'Internal Audit updated successfully!',
            'audit' => $audit,
        ]);
    }

    /**
     * Remove the specified internal audit from storage.
     */
    public function destroy($id)
    {
        $this->InternalAuditInterface->deleteById($id);

        return response()->json([
            'message' => 'Internal Audit deleted successfully!',
        ]);
    }
}
