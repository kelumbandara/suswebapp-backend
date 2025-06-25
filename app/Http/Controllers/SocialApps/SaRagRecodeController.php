<?php
namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaRagRecord\RagRecordRequest;
use App\Repositories\All\SaRagRecode\RagRecodeInterface;
use App\Repositories\All\SaRrCountryName\RrCountryNameInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class SaRagRecodeController extends Controller
{
    protected $ragRecodeInterface;
    protected $userInterface;

    public function __construct(RagRecodeInterface $ragRecodeInterface, UserInterface $userInterface)
    {
        $this->ragRecodeInterface = $ragRecodeInterface;
        $this->userInterface      = $userInterface;
    }


     public function index()
    {
        $record = $this->ragRecodeInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

        $record = $record->map(function ($risk) {

            try {
                $creator                 = $this->userInterface->getById($risk->createdByUser);
                $risk->createdByUser = $creator ?? (object) ['name' => 'Unknown', 'id' => null];
            } catch (\Exception $e) {
                $risk->createdByUser = 'Unknown';
            }

            return $risk;
        });

        return response()->json($record, 200);
    }

    public function store(RagRecordRequest $request)
    {

        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;


        $record = $this->ragRecodeInterface->create($validatedData);

        return response()->json([
            'message'    => 'RAG record created successfully!',
            'record' => $record,
        ], 201);
    }

        public function update($id, RagRecordRequest $request)
    {
        $record = $this->ragRecodeInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'RAG record not found.'], 404);
        }

        $validatedData = $request->validated();
        $updated = $this->ragRecodeInterface->update($id, $validatedData);

        if ($updated) {
            return response()->json([
                'message'    => 'RAG record updated successfully!',
                'record' => $this->ragRecodeInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the RAG record.'], 500);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->ragRecodeInterface->deleteById($id);

        return response()->json([
            'message' => $deleted ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $deleted ? 200 : 500);
    }



}
