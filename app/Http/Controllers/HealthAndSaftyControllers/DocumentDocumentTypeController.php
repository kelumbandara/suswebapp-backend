<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsDocumentDocumentType\DocumentTypeRequest;
use App\Repositories\All\HSDocumentDocumentType\DocumentTypeInterface;
use Illuminate\Http\Request;

class DocumentDocumentTypeController extends Controller
{
    protected $documentTypeInterface;

    public function __construct(DocumentTypeInterface $documentTypeInterface)
    {
        $this->documentTypeInterface = $documentTypeInterface;
    }

    public function index()
    {
        $Document = $this->documentTypeInterface->all();
        return response()->json($Document);
    }


    public function store(DocumentTypeRequest $request)
    {
        $data = $request->validated();
        $Document = $this->documentTypeInterface->create($data);
        return response()->json([
            'message' => 'Document created successfully',
            'data' => $Document
        ], 201);
    }
}
