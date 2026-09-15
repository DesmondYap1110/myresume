<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Stores an uploaded image safely.
 *
 * The browser's file name, extension and MIME type are never trusted. The
 * file must decode as a real JPEG/PNG/GIF/WebP, and is then re-drawn by GD
 * into a new file, so only pixels survive: any script, HTML, PHP or other
 * payload hidden in the original (polyglot files, EXIF comments) is dropped.
 * The name is random and the extension is the one we wrote.
 */
class SafeImageUpload
{
    /** Largest width/height accepted - guards against decompression bombs. */
    public const MAX_DIMENSION = 5000;

    private const TYPES = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];

    /**
     * Re-encodes $file into public/$directory and returns the path relative
     * to public/, e.g. "uploads/7f3c...e1.jpg".
     *
     * @throws ValidationException when the file is not a usable image
     */
    public static function store(UploadedFile $file, string $directory, string $field = 'image'): string
    {
        $fail = fn (string $message) => throw ValidationException::withMessages([$field => $message]);

        if (! $file->isValid()) {
            $fail('The upload failed. Please try again.');
        }

        $info = @getimagesize($file->getRealPath());

        if ($info === false || ! isset(self::TYPES[$info[2]])) {
            $fail('The file must be a real JPG, PNG, GIF or WebP image.');
        }

        [$width, $height, $type] = $info;

        if ($width < 1 || $height < 1 || $width > self::MAX_DIMENSION || $height > self::MAX_DIMENSION) {
            $fail('The image must be at most '.self::MAX_DIMENSION.' x '.self::MAX_DIMENSION.' pixels.');
        }

        $contents = file_get_contents($file->getRealPath());
        $image = $contents === false ? false : @imagecreatefromstring($contents);

        if ($image === false) {
            $fail('The image could not be read. It may be damaged.');
        }

        $extension = self::TYPES[$type];
        $relative = trim($directory, '/').'/'.Str::random(40).'.'.$extension;
        $target = public_path($relative);

        if (! is_dir(dirname($target))) {
            mkdir(dirname($target), 0755, true);
        }

        if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_WEBP, IMAGETYPE_GIF], true)) {
            imagepalettetotruecolor($image);
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        $written = match ($type) {
            IMAGETYPE_JPEG => imagejpeg($image, $target, 90),
            IMAGETYPE_PNG => imagepng($image, $target, 6),
            IMAGETYPE_GIF => imagegif($image, $target),
            IMAGETYPE_WEBP => imagewebp($image, $target, 90),
        };

        imagedestroy($image);

        if (! $written) {
            @unlink($target);
            $fail('The image could not be saved.');
        }

        return $relative;
    }

    /**
     * Deletes a file created by store(), and nothing outside $directory.
     */
    public static function delete(?string $relative, string $directory): void
    {
        $prefix = trim($directory, '/').'/';

        if (! is_string($relative) || ! str_starts_with($relative, $prefix) || str_contains($relative, '..')) {
            return;
        }

        $path = public_path($relative);

        if (is_file($path)) {
            @unlink($path);
        }
    }
}
