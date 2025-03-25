<?php
namespace App\Http\Controllers\HealthAndSaftyControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HsDocumentRecode\DocumentRecodeRequest;
use App\Repositories\All\HSDocumentRecode\DocumentInterface;
use App\Repositories\All\User\UserInterface;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;

class DocumentRecodeController extends Controller
{
    protected $documentInterface;
    protected $userInterface;
    protected $documentService;

    public function __construct(DocumentInterface $documentInterface, UserInterface $userInterface, DocumentService $documentService)
    {
        $this->documentInterface = $documentInterface;
        $this->userInterface     = $userInterface;
        $this->documentService   = $documentService;

    }

    public function index()
{
    $document = $this->documentInterface->all();

    $document = $document->map(function ($risk) {
        try {
            $assignee           = $this->userInterface->getById($risk->assignee);
            $risk->assigneeName = $assignee ? $assignee->name : 'Unknown';
        } catch (\Exception $e) {
            $risk->assigneeName = 'Unknown';
        }

        try {
            $creator                 = $this->userInterface->getById($risk->createdByUser);
            $risk->createdByUserName = $creator ? $creator->name : 'Unknown';
        } catch (\Exception $e) {
            $risk->createdByUserName = 'Unknown';
        }

        if (! empty($risk->document) && is_array($risk->document)) {
            $updatedDocuments = [];

            foreach ($risk->document as $doc) {
                if (isset($doc['gsutil_uri'])) {
                    $imageData = $this->documentService->getImageUrl($doc['gsutil_uri']);
                    $doc['fileName']  = $imageData['fileName'];
                    $doc['imageUrl'] = $imageData['signedUrl'];
                }
                $updatedDocuments[] = $doc;
            }

            $risk->setAttribute('document', $updatedDocuments);
        } else {
            $risk->setAttribute('document', []);
        }

        return $risk;
    });

    return response()->json($document);
}


    public function store(DocumentRecodeRequest $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data                  = $request->validated();
        $data['createdByUser'] = $user->id;
        $data['isNoExpiry']    = filter_var($data['isNoExpiry'], FILTER_VALIDATE_BOOLEAN);

        if ($request->hasFile('document')) {
            $uploadedFiles = [];

            foreach ($request->file('document') as $file) {
                $uploadedFiles[] = $this->documentService->uploadImageToGCS($file);
            }

            $data['document'] = ($uploadedFiles);
        }

        $document = $this->documentInterface->create($data);

        return response()->json([
            'message' => 'Document created successfully',
            'data'    => $document,
        ], 201);
    }

    public function update(DocumentRecodeRequest $request, $id)
    {
        $document = $this->documentInterface->findById($id);
        if (! $document) {
            return response()->json(['message' => 'Document not found']);
        }

        $data               = $request->validated();
        $data['isNoExpiry'] = filter_var($data['isNoExpiry'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($request->has('document') && $request->has('removeDoc')) {
            $removeDocs = $request->input('removeDoc');
            $newFiles   = $request->file('document');

            if (is_array($removeDocs)) {
                foreach ($removeDocs as $removeDoc) {
                    $this->documentService->removeOldDocumentFromStorage($removeDoc);
                }
            }

            $result = [];
            foreach ($newFiles as $newFile) {
                $uploadResult = $this->documentService->updateDocuments($newFile, null);

                $result[] = [
                    'gsutil_uri' => $uploadResult['gsutil_uri'],
                ];
            }

            if (empty($result)) {
                return response()->json(['message' => 'Failed to update the documents.'], 500);
            }

            $validatedData['document'] = json_encode($result);
        }

        $updatedDocument = $this->documentInterface->update($id, $data);

        return response()->json([
            'message' => 'Document updated successfully',
            'data'    => $updatedDocument,
        ]);
    }

    public function destroy($id)
    {
        $document = $this->documentInterface->findById($id);

        if (! empty($document->documents)) {
            if (is_string($document->documents)) {
                $documents = json_decode($document->documents, true);
            } else {
                $documents = $document->documents;
            }

            if (is_array($documents)) {
                foreach ($documents as $document) {
                    $this->documentService->deleteImageFromGCS($document);
                }
            }
        }

        $this->documentInterface->deleteById($id);

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
