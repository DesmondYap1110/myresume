<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

/**
 * One door for blog uploads: a picture goes to SafeImageUpload, a video to
 * SafeVideoUpload, and the caller does not have to know which it was given.
 *
 * What is actually in the file decides, not its name or the MIME type the
 * browser claimed.
 */
class SafeMediaUpload
{
    public static function store(UploadedFile $file, string $directory, string $field = 'media'): string
    {
        return self::looksLikeVideo($file)
            ? SafeVideoUpload::store($file, $directory, $field)
            : SafeImageUpload::store($file, $directory, $field);
    }

    /** True when the bytes begin with a video container we accept. */
    public static function looksLikeVideo(UploadedFile $file): bool
    {
        return $file->isValid() && SafeVideoUpload::detect($file->getRealPath()) !== null;
    }

    /** Remove a file either helper created. */
    public static function delete(?string $relative, string $directory): void
    {
        SafeImageUpload::delete($relative, $directory);
    }

    /** Whether a stored path is a video, for choosing <img> or <video>. */
    public static function isVideo(?string $path): bool
    {
        return SafeVideoUpload::isVideo($path);
    }

    /** What the file picker should offer. */
    public static function accept(): string
    {
        return 'image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm';
    }
}
