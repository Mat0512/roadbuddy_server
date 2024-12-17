<?php

namespace App\Utils;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class FileUploader
{
    /**
     * Upload an image to Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public static function uploadImageToCloudinary($file)
    {
        // Upload image to Cloudinary
        $uploadedFile = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'service_provider_uploads'
        ]);

        return $uploadedFile->getSecurePath(); // Return the URL of the uploaded image
    }

    /**
     * Handle file uploads for a specific field.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $fieldName
     * @return string|null
     */
    public static function handleFileUpload(Request $request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            return self::uploadImageToCloudinary($request->file($fieldName));
        }

        return null;
    }
}
