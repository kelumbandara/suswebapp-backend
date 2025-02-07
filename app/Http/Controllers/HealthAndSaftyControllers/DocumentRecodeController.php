<?php

namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsDocumentRecode\DocumentRecodeRequest;
use App\Repositories\All\HSDocumentRecode\DocumentInterface;

class DocumentRecodeController extends Controller
{
    protected $documentInterface;

    public function __construct(DocumentInterface $documentInterface)
    {
        $this->documentInterface = $documentInterface;
    }

    public function index()
    {
        $document = $this->documentInterface->all();
        return response()->json($document);
    }


    public function store(DocumentRecodeRequest $request)
    {
        $data = $request->validated();
        $document = $this->documentInterface->create($data);
        return response()->json([
            'message' => 'Document created successfully',
            'data' => $document
        ], 201);
    }

    public function update(DocumentRecodeRequest $request, $id)
    {
        $document = $this->documentInterface->findById($id);
        if (! $document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        $data = $request->validated();
        $updatedDocument = $this->documentInterface->update($id, $data);

        return response()->json([
            'message' => 'Document updated successfully',
            'data' => $updatedDocument
        ]);
    }

    public function destroy($id)
    {
        $document = $this->documentInterface->findById($id);
        if (! $document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        $this->documentInterface->deleteById($id);

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
