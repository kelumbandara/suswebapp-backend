<?php

namespace App\Http\Controllers;

use App\Models\ImageSave;
use App\Services\ImageUploadService;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $file = $request->file('image');

        $result = $this->imageUploadService->uploadImageToGCS($file);

        return response()->json([
            'message' => 'File uploaded and saved successfully!',
            'gsutil_uri' => $result['gsutil_uri'],
            'image_id' => $result['image_id'],
        ]);
    }

    public function getImage($imageId)
    {
        $publicUrl = $this->imageUploadService->getImageUrl($imageId);

        if (!$publicUrl) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->json([
            'message' => 'Image retrieved successfully!',
            'public_url' => $publicUrl,
        ]);
    }

}
