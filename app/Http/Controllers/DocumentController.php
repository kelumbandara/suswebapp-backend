<?php
namespace App\Http\Controllers;

use App\Http\Requests\HealthAndSafety\DocumentRequest;
use App\Repositories\All\HSDocuments\DocumentInterface;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    protected DocumentInterface $documentInterface;

    public function __construct(DocumentInterface $documentInterface)
    {
        $this->documentInterface = $documentInterface;
    }

    public function index()
    {
        $documents = $this->documentInterface->all();

        return response()->json($documents);
    }

    public function store(DocumentRequest $request)
    {
        $validated = $request->validated();

        $validated['id'] = Str::uuid();

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('documents', 'public');
        }

        $document = $this->documentInterface->create($validated);

        if (! $document) {
            return response()->json(['message' => 'Document creation failed'], 500);
        }

        return response()->json([
            'message'      => 'Document created successfully',
            'data'         => $document,
            'document_url' => $document->document ? asset('storage/' . $document->document) : null,
        ], 201);
    }

    public function update(DocumentRequest $request, $id)
    {
        $validated = $request->validated();

        $document = $this->documentInterface->update($id, $validated);

        return response()->json([
            'message' => 'Document updated successfully',
            'data'    => $document,
        ]);
    }

    /**
     * Remove the specified document from the repository.
     */
    // public function destroy($id)
    // {
    //     // Use the repository to delete the document
    //     $this->documentInterface->deleteById($id);
    //     return response()->json(['message' => 'Document deleted successfully']);
    // }
}
