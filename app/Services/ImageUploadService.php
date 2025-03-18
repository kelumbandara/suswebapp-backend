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

        $gsutilUri = "gs://" . env('GOOGLE_CLOUD_STORAGE_BUCKET') . "/{$fileName}";

        $imageSave = ImageSave::create([
            'fileName' => $fileName,
            'filePath' => $gsutilUri,
        ]);

        return [
            'gsutil_uri' => $gsutilUri,
            'image_id'   => $imageSave->id,
        ];
    }

    public function getImageUrl($imageId)
    {
        $image = ImageSave::find($imageId);

        if (! $image) {
            return null;
        }

        $gsutilUri = $image->filePath;
        $filePath  = str_replace('gs://' . env('GOOGLE_CLOUD_STORAGE_BUCKET') . '/', '', $gsutilUri);

        // Explicitly load credentials
        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path(env('GOOGLE_CLOUD_KEY_FILE'))), true),
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $object = $bucket->object($filePath);

        // Set expiration time (e.g., 15 minutes)
        $expiresAt = Carbon::now()->addMinutes(15);

        // Generate signed URL
        $signedUrl = $object->signedUrl($expiresAt);

        return $signedUrl;
    }

    public function deleteImage($imageId)
    {
        $image = ImageSave::find($imageId);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // Extract file path from GCS URL
        $gsutilUri = $image->filePath;
        $filePath = str_replace('gs://'.env('GOOGLE_CLOUD_STORAGE_BUCKET').'/', '', $gsutilUri);

        // Initialize Google Cloud Storage
        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path(env('GOOGLE_CLOUD_KEY_FILE'))), true)
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $object = $bucket->object($filePath);

        // Check if the file exists before deleting
        if ($object->exists()) {
            $object->delete();

            // Double-check if the file was successfully deleted
            if (!$object->exists()) {
                // Delete record from database
                $image->delete();

                return response()->json(['message' => 'Image deleted successfully from Cloud Storage!']);
            } else {
                return response()->json(['message' => 'Failed to delete image from Cloud Storage'], 500);
            }
        } else {
            return response()->json(['message' => 'Image not found in Cloud Storage'], 404);
        }
    }

    public function updateImage($imageId, $newFile)
    {
        $image = ImageSave::find($imageId);

        if (! $image) {
            return false;
        }

        $oldGsutilUri = $image->filePath;
        $oldFilePath  = str_replace('gs://' . env('GOOGLE_CLOUD_STORAGE_BUCKET') . '/', '', $oldGsutilUri);

        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path(env('GOOGLE_CLOUD_KEY_FILE'))), true),
        ]);

        $bucket    = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $oldObject = $bucket->object($oldFilePath);

        if ($oldObject->exists()) {
            $oldObject->delete();
        }

        $newFileName = 'uploads/' . uniqid() . '_' . $newFile->getClientOriginalName();
        Storage::disk('gcs')->put($newFileName, file_get_contents($newFile));

        $newGsutilUri = "gs://" . env('GOOGLE_CLOUD_STORAGE_BUCKET') . "/{$newFileName}";

        $image->update([
            'fileName' => $newFileName,
            'filePath' => $newGsutilUri,
        ]);

        return [
            'message'    => 'Image updated successfully!',
            'gsutil_uri' => $newGsutilUri,
            'image_id'   => $image->id,
        ];
    }

}
