<?php
namespace App\Http\Controllers;

use App\Models\ImageSave;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

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
            'message'    => 'File uploaded and saved successfully!',
            'gsutil_uri' => $result['gsutil_uri'],
            'image_id'   => $result['image_id'],
        ]);
    }

    public function getImage($imageId)
    {
        $publicUrl = $this->imageUploadService->getImageUrl($imageId);

        if (! $publicUrl) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->json([
            'message'    => 'Image retrieved successfully!',
            'public_url' => $publicUrl,
        ]);
    }
    public function deleteImage($imageId)
    {
        // Find the image in the database
        $image = ImageSave::find($imageId);

        if (!$image) {
            return response()->json(['message' => 'Image not found in database'], 404);
        }

        // Delete the image from Google Cloud Storage
        $deleted = $this->imageUploadService->deleteImage($imageId);

        if (!$deleted) {
            return response()->json(['message' => 'Failed to delete image from Cloud Storage'], 500);
        }

        // Now delete the record from the database
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully from Cloud Storage and database!']);
    }


    public function updateImage(Request $request, $imageId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $newFile = $request->file('image');

        $result = $this->imageUploadService->updateImage($imageId, $newFile);

        if (! $result) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->json([
            'message'    => $result['message'],
            'gsutil_uri' => $result['gsutil_uri'],
            'image_id'   => $result['image_id'],
        ]);
    }

}
