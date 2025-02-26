<?php

namespace App\Http\Controllers;

use App\Models\ImageSave;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $file = $request->file('image');

        $fileName = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();

        Storage::disk('gcs')->put($fileName, file_get_contents($file));

        $gsutilUri = "gs://".env('GOOGLE_CLOUD_STORAGE_BUCKET')."/{$fileName}";

        $imageSave = ImageSave::create([
            'fileName' => $fileName,
            'filePath' => $gsutilUri,
        ]);

        return response()->json([
            'message' => 'File uploaded and saved successfully!',
            'gsutil_uri' => $gsutilUri,
            'image_id' => $imageSave->id,
        ]);
    }


    public function getImage($imageId)
    {
        $image = ImageSave::find($imageId);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $gsutilUri = $image->filePath;

        $filePath = str_replace('gs://'.env('GOOGLE_CLOUD_STORAGE_BUCKET').'/', '', $gsutilUri);

        $publicUrl = "https://storage.googleapis.com/".env('GOOGLE_CLOUD_STORAGE_BUCKET')."/{$filePath}";

        return response()->json([
            'message' => 'Image retrieved successfully!',
            'public_url' => $publicUrl,
        ]);
    }

}
