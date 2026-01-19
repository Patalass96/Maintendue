<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Extensions autorisées pour les images
     */
    protected array $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Extensions autorisées pour les documents
     */
    protected array $allowedDocumentExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

    /**
     * Taille maximale pour les images (MB)
     */
    protected int $maxImageSize = 5;

    /**
     * Taille maximale pour les documents (MB)
     */
    protected int $maxDocumentSize = 10;

    /**
     * Uploader une image
     */
    public function uploadImage(UploadedFile $file, string $path = 'donations'): ?string
    {
        if (!$this->isValidImage($file)) {
            throw new \InvalidArgumentException('Invalid image file');
        }

        $filename = $this->generateFilename($file);
        $fullPath = "images/{$path}";

        // Stocker l'image originale
        $stored = Storage::disk('public')->putFileAs($fullPath, $file, $filename);

        if ($stored) {
            // Créer des miniatures
            $this->createThumbnails($file, $fullPath, $filename);
            return $stored;
        }

        return null;
    }

    /**
     * Uploader plusieurs images
     */
    public function uploadImages(array $files, string $path = 'donations'): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploaded = $this->uploadImage($file, $path);
                if ($uploaded) {
                    $uploadedFiles[] = $uploaded;
                }
            }
        }

        return $uploadedFiles;
    }

    /**
     * Uploader un document
     */
    public function uploadDocument(UploadedFile $file, string $path = 'documents'): ?string
    {
        if (!$this->isValidDocument($file)) {
            throw new \InvalidArgumentException('Invalid document file');
        }

        $filename = $this->generateFilename($file);
        $fullPath = "documents/{$path}";

        return Storage::disk('public')->putFileAs($fullPath, $file, $filename);
    }

    /**
     * Supprimer une image
     */
    public function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            // Supprimer l'image originale
            Storage::disk('public')->delete($path);

            // Supprimer les miniatures
            $this->deleteThumbnails($path);

            return true;
        }

        return false;
    }

    /**
     * Supprimer plusieurs images
     */
    public function deleteImages(array $paths): bool
    {
        $deleted = 0;
        foreach ($paths as $path) {
            if ($this->deleteImage($path)) {
                $deleted++;
            }
        }

        return $deleted === count($paths);
    }

    /**
     * Supprimer un document
     */
    public function deleteDocument(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Obtenir l'URL publique d'un fichier
     */
    public function getUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Valider une image
     */
    public function isValidImage(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize() / (1024 * 1024); // Convertir en MB

        if (!in_array($extension, $this->allowedImageExtensions)) {
            throw new \InvalidArgumentException("Extension {$extension} not allowed for images");
        }

        if ($size > $this->maxImageSize) {
            throw new \InvalidArgumentException("Image size must be less than {$this->maxImageSize}MB");
        }

        // Vérifier que c'est réellement une image
        $mimeType = $file->getMimeType();
        if (!str_starts_with($mimeType, 'image/')) {
            throw new \InvalidArgumentException('File is not a valid image');
        }

        return true;
    }

    /**
     * Valider un document
     */
    public function isValidDocument(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $size = $file->getSize() / (1024 * 1024); // Convertir en MB

        if (!in_array($extension, $this->allowedDocumentExtensions)) {
            throw new \InvalidArgumentException("Extension {$extension} not allowed for documents");
        }

        if ($size > $this->maxDocumentSize) {
            throw new \InvalidArgumentException("Document size must be less than {$this->maxDocumentSize}MB");
        }

        return true;
    }

    /**
     * Générer un nom de fichier unique
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return Str::uuid() . '.' . $extension;
    }

    /**
     * Créer des miniatures pour une image
     */
    protected function createThumbnails(UploadedFile $file, string $path, string $filename): void
    {
        try {
            // Pour créer les miniatures, nous utilisons une approche simple
            // Dans un vrai projet, intégrer Intervention/Image correctement
            // Pour maintenant, on sauvegarde juste l'image originale
            \Log::info('Thumbnails creation skipped - requires Intervention/Image configuration');
        } catch (\Exception $e) {
            \Log::error('Thumbnail generation error: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer les miniatures
     */
    protected function deleteThumbnails(string $path): void
    {
        $basePath = dirname($path);
        $filename = basename($path);

        Storage::disk('public')->delete([
            "{$basePath}/thumbnails/200x200/{$filename}",
            "{$basePath}/thumbnails/400x400/{$filename}",
        ]);
    }

    /**
     * Obtenir l'URL d'une miniature
     */
    public function getThumbnailUrl(string $path, string $size = '200x200'): string
    {
        $basePath = dirname($path);
        $filename = basename($path);
        $thumbnailPath = "{$basePath}/thumbnails/{$size}/{$filename}";

        return Storage::disk('public')->url($thumbnailPath);
    }
}
