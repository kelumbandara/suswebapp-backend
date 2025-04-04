<?php
namespace App\Services;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class BenefitDocumentService
{
    public function uploadImageToGCS($file)
    {
        $fileName = 'uploads/BenefitDocument/' . uniqid() . '_' . $file->getClientOriginalName();

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

    public function deleteImageFromGCS($gsutilUri)
    {
        if (! $gsutilUri) {
            return false;
        }

        $filePath = str_replace('gs://' . env('GOOGLE_CLOUD_STORAGE_BUCKET') . '/', '', $gsutilUri);

        return Storage::disk('gcs')->delete($filePath);
    }

    public function updateDocuments($newFile, $removeDoc)
    {
        if ($removeDoc) {
            $this->removeOldDocumentFromStorage($removeDoc);
        }

        $newFileName = 'uploads/BenefitDocument/' . uniqid() . '_' . $newFile->getClientOriginalName();
        Storage::disk('gcs')->put($newFileName, file_get_contents($newFile));

        $newGsutilUri = "gs://" . env('GOOGLE_CLOUD_STORAGE_BUCKET') . "/{$newFileName}";

        return [
            'gsutil_uri' => $newGsutilUri,
        ];
    }

    /**
     * Removes the old document from Google Cloud Storage.
     *
     * @param string $removeDoc The Google Cloud Storage URI of the document to remove.
     */
    public function removeOldDocumentFromStorage($removeDoc)
    {
        $oldFilePath = str_replace('gs://' . env('GOOGLE_CLOUD_STORAGE_BUCKET') . '/', '', $removeDoc);

        $storage = new StorageClient([
            'keyFile' => json_decode(file_get_contents(base_path(env('GOOGLE_CLOUD_KEY_FILE'))), true),
        ]);

        $bucket    = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
        $oldObject = $bucket->object($oldFilePath);

        if ($oldObject->exists()) {
            $oldObject->delete();
        }
    }
    
}
