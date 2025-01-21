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
        if ($data['is_supplier_audit']) {
            // Ensure the supplier fields are present in the request
            $data['supplier_type'] = $request->input('supplier_type');
            $data['factory_license_no'] = $request->input('factory_license_no');
            $data['higg_id'] = $request->input('higg_id');
            $data['zdhc_id'] = $request->input('zdhc_id');
            $data['process_type'] = $request->input('process_type');
        }
        $data['reference_id'] = 'AUD-' . strtoupper(uniqid());
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
                'supplier_details' => [
                    'supplier_type' => $audit->supplier_type,
                    'factory_license_no' => $audit->factory_license_no,
                    'higg_id' => $audit->higg_id,
                    'zdhc_id' => $audit->zdhc_id,
                    'process_type' => $audit->process_type,
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
