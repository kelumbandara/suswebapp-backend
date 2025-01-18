<?php

namespace App\Http\Controllers;

use App\Models\HSDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        return response()->json(HSDocument::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_number' => 'required|integer',
            'version_number' => 'required|integer',
            'document_type' => 'required|string',
            'title' => 'required|string',
            'division' => 'required|string',
            'issuing_authority' => 'required|string',
            'document_owner' => 'nullable|string',
            'document_reviewer' => 'required|string',
            'physical_location' => 'nullable|string',
            'remarks' => 'nullable|string',
            'document' => 'nullable|array',
            'issued_date' => 'required|date',
            'is_no_expiry' => 'required|boolean',
            'expiry_date' => 'nullable|date|required_if:is_no_expiry,false',
            'notify_date' => 'nullable|date|required_if:is_no_expiry,false',
            'created_date' => 'nullable|date',
            'created_by' => 'nullable|string',
            'document' => 'nullable|string|max:2048',

        ]);

        $validated['id'] = Str::uuid();

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('documents', 'public');
        }

        $document = HSDocument::create($validated);

        return response()->json([
            'message' => 'Document created successfully',
            'data' => $document,
            'document_url' => asset('storage/' . $document->document)
        ], 201);
    }

    // public function show($id)
    // {
    //     $document = Document::findOrFail($id);

    //     return response()->json($document);
    // }

    public function update(Request $request, $id)
    {
        $document = HSDocument::findOrFail($id);

        $validated = $request->validate([
            'document_number' => 'required|integer',
            'version_number' => 'required|integer',
            'document_type' => 'required|string',
            'title' => 'required|string',
            'division' => 'required|string',
            'issuing_authority' => 'required|string',
            'document_owner' => 'nullable|string',
            'document_reviewer' => 'required|string',
            'physical_location' => 'nullable|string',
            'remarks' => 'nullable|string',
            'document' => 'nullable|array',
            'issued_date' => 'required|date',
            'is_no_expiry' => 'required|boolean',
            'expiry_date' => 'nullable|date|required_if:is_no_expiry,false',
            'notify_date' => 'nullable|date|required_if:is_no_expiry,false',
            'created_date' => 'nullable|date',
            'created_by' => 'nullable|string',
        ]);

        $document->update($validated);

        return response()->json($document);
    }

    // public function destroy($id)
    // {
    //     $document = HSDocument::findOrFail($id);
    //     $document->delete();

    //     return response()->json(['message' => 'Document deleted successfully']);
    // }
}
