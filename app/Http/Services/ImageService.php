<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Traite et enregistre une image pour un don
     */
    public function processDonationImage(UploadedFile $file, bool $isPrimary = false): array
    {
        // Générer un nom unique
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = 'donations/' . date('Y/m') . '/' . $filename;

        // Sauvegarder l'image directement
        $file->storeAs('public/donations', $filename);

        return [
            'path' => $path,
            'filename' => $filename,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Supprimer toutes les versions d'une image
     */
    public function deleteImage(string $path): void
    {
        $basePath = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $patterns = [
            $path,
            str_replace('.'.$extension, '_thumb.'.$extension, $path),
            str_replace('.'.$extension, '_medium.'.$extension, $path),
            str_replace('.'.$extension, '_large.'.$extension, $path),
        ];

        foreach ($patterns as $pattern) {
            if (Storage::disk('public')->exists($pattern)) {
                Storage::disk('public')->delete($pattern);
            }
        }
    }
}
