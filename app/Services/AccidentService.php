<?php
namespace App\Services;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AccidentService
{
    public function uploadImageToGCS($file)
    {
        $fileName = 'uploads/Accident/' . uniqid() . '_' . $file->getClientOriginalName();

        Storage::disk('gcs')->put($fileName, file_get_contents($file));

        $gsutilUri = "gs://" . env('GOOGLE_CLOUD_STORAGE_BUCKET') . "/{$fileName}";

        return [
            'gsutil_uri' => $gsutilUri,

        ];
    }

    public function getImageUrl($gsutilUri)
    {
        $filePath = str_replace('gs://' . env('GOOGLE_CLOUD_STORAGE_BUCKET') . '/', '', $gsutilUri);
        $fileName = basename($filePath);

        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path(env('GOOGLE_CLOUD_KEY_FILE'))), true),
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $object = $bucket->object($filePath);

        $expiresAt = Carbon::now()->addMinutes(15);
        $signedUrl = $object->signedUrl($expiresAt);

        return [
            'fileName'  => $fileName,
            'signedUrl' => $signedUrl,
        ];
    }

}
