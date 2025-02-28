<?php

namespace App\Services;

use App\Models\ImageSave;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    public function uploadImageToGCS($file)
    {
        $fileName = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();

        Storage::disk('gcs')->put($fileName, file_get_contents($file));

        $gsutilUri = "gs://".env('GOOGLE_CLOUD_STORAGE_BUCKET')."/{$fileName}";

        $imageSave = ImageSave::create([
            'fileName' => $fileName,
            'filePath' => $gsutilUri,
        ]);

        return [
            'gsutil_uri' => $gsutilUri,
            'image_id' => $imageSave->id,
        ];
    }

    public function getImageUrl($imageId)
    {
        $image = ImageSave::find($imageId);

        if (!$image) {
            return null;
        }

        $gsutilUri = $image->filePath;
        $filePath = str_replace('gs://'.env('GOOGLE_CLOUD_STORAGE_BUCKET').'/', '', $gsutilUri);

        // Explicitly load credentials
        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path(env('GOOGLE_CLOUD_KEY_FILE'))), true)
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $object = $bucket->object($filePath);

        // Set expiration time (e.g., 15 minutes)
        $expiresAt = Carbon::now()->addMinutes(15);

        // Generate signed URL
        $signedUrl = $object->signedUrl($expiresAt);

        return $signedUrl;
    }
}
