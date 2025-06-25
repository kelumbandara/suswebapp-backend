<?php

namespace App\Http\Controllers\SocialApps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaAttritionRecord\AttritionRecordRequest;
use App\Repositories\All\SaAttritionRecord\AttritionRecordInterface;
use App\Repositories\All\SaRrCountryName\RrCountryNameInterface;
use App\Repositories\All\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class SaAttritionRecordController extends Controller
{

    protected $attritionRecordInterface;
    protected $userInterface;

    public function __construct(AttritionRecordInterface $attritionRecordInterface, UserInterface $userInterface)
    {
        $this->attritionRecordInterface = $attritionRecordInterface;
        $this->userInterface      = $userInterface;
    }


    public function index()
    {
        $record = $this->attritionRecordInterface->All()->sortByDesc('created_at')->sortByDesc('updated_at')->values();

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

    public function store(AttritionRecordRequest $request)
    {

        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $userId                         = $user->id;
        $validatedData                  = $request->validated();
        $validatedData['createdByUser'] = $userId;


        $record = $this->attritionRecordInterface->create($validatedData);

        return response()->json([
            'message'    => 'Attrition record created successfully!',
            'record' => $record,
        ], 201);
    }


        public function update($id, AttritionRecordRequest $request)
    {
        $record = $this->attritionRecordInterface->findById($id);

        if (! $record) {
            return response()->json(['message' => 'Attrition record not found.'], 404);
        }

        $validatedData = $request->validated();
        $updated = $this->attritionRecordInterface->update($id, $validatedData);

        if ($updated) {
            return response()->json([
                'message'    => 'Attrition record updated successfully!',
                'record' => $this->attritionRecordInterface->findById($id),
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to update the attrition record.'], 500);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->attritionRecordInterface->deleteById($id);

        return response()->json([
            'message' => $deleted ? 'Record deleted successfully!' : 'Failed to delete record.',
        ], $deleted ? 200 : 500);
    }

}
