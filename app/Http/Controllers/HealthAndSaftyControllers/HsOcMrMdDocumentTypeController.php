<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsHsOcMrMdDocumentType\DocumentTypeRequest;
use App\Repositories\All\HsOcMrMdDocumentType\DocumentTypeInterface;
use Illuminate\Http\Request;

class HsOcMrMdDocumentTypeController extends Controller
{
    protected $documentTypeInterface;

    public function __construct(DocumentTypeInterface $documentTypeInterface)
    {
        $this->documentTypeInterface = $documentTypeInterface;
    }

    public function index()
    {
        $supplierName = $this->documentTypeInterface->All();

        return response()->json($supplierName, 200);
    }

    public function store(DocumentTypeRequest $request)
    {
        $supplierName = $this->documentTypeInterface->create($request->validated());

        return response()->json([
            'message' => 'Document Type created successfully.',
            'data'    => $supplierName,
        ], 201);
    }

    public function update(DocumentTypeRequest $request, string $id)
    {
        $supplierName = $this->documentTypeInterface->findById($id);

        if (! $supplierName) {
            return response()->json([
                'message' => 'Document Type not found.',
            ], );
        }

        $this->documentTypeInterface->update($id, $request->validated());

        return response()->json([
            'message' => 'Document Type  updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $supplierName = $this->documentTypeInterface->findById($id);

        if (! $supplierName) {
            return response()->json([
                'message' => 'Document Type not found.',
            ], );
        }

        $this->documentTypeInterface->deleteById($id);

        return response()->json([
            'message' => 'Document Type deleted successfully.',
        ], 200);
    }
}
