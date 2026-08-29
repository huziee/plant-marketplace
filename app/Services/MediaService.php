<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Store an uploaded file and create Media database record.
     */
    public function upload(UploadedFile $file, ?int $userId = null, string $disk = 'public', string $folder = 'uploads'): Media
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $originalName = $file->getClientOriginalName();
        $fileName = Str::uuid() . '.' . $extension;
        
        $filePath = $file->storeAs($folder, $fileName, $disk);

        $width = null;
        $height = null;

        // Try getting image dimensions if it's an image
        if (str_starts_with($file->getMimeType(), 'image/')) {
            try {
                $imageSize = @getimagesize($file->getRealPath());
                if ($imageSize) {
                    $width = $imageSize[0];
                    $height = $imageSize[1];
                }
            } catch (\Throwable $e) {
                // Ignore dimension extraction errors gracefully
            }
        }

        return Media::create([
            'user_id' => $userId,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'file_path' => $filePath,
            'disk' => $disk,
            'mime_type' => $file->getMimeType(),
            'extension' => $extension,
            'size' => $file->getSize(),
            'width' => $width,
            'height' => $height,
            'title' => pathinfo($originalName, PATHINFO_FILENAME),
            'alt_text' => pathinfo($originalName, PATHINFO_FILENAME),
        ]);
    }

    /**
     * Delete media record and remove physical file from storage.
     */
    public function delete(Media $media): bool
    {
        if (Storage::disk($media->disk)->exists($media->file_path)) {
            Storage::disk($media->disk)->delete($media->file_path);
        }

        return $media->delete();
    }
}
