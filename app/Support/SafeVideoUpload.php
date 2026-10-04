<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Stores an uploaded video.
 *
 * An image can be re-drawn by GD so that only pixels survive. A video cannot
 * - re-encoding would need ffmpeg - so safety here rests on three things
 * instead:
 *
 *   - the file must begin with a real MP4 or WebM container signature, so a
 *     renamed script or HTML file is refused;
 *   - the stored name is random and the extension is the one we wrote, never
 *     the browser's, so nothing can land as .php or .phtml;
 *   - the file is only ever served as a static download from public/uploads.
 *
 * It is still bytes we did not author, so it is served, never parsed.
 */
class SafeVideoUpload
{
    /** Larger than an image, but not so large it fills the disk. */
    public const MAX_BYTES = 20 * 1024 * 1024;

    public const extensions = ['mp4', 'webm'];

    public static function store(UploadedFile $file, string $directory, string $field = 'video'): string
    {
        $fail = fn (string $message) => throw ValidationException::withMessages([$field => $message]);

        if (!$file->isValid()) {
            $fail('The upload failed. Please try again.');
        }

        if ($file->getSize() > self::MAX_BYTES) {
            $fail('Each video must be '.(int) (self::MAX_BYTES / 1024 / 1024).' MB or smaller.');
        }

        $extension = self::detect($file->getRealPath());

        if ($extension === null) {
            $fail('The file must be a real MP4 or WebM video.');
        }

        $relative = trim($directory, '/').'/'.Str::random(40).'.'.$extension;
        $target = public_path($relative);

        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0755, true);
        }

        if (!@copy($file->getRealPath(), $target)) {
            $fail('The video could not be saved.');
        }

        @chmod($target, 0644);

        return $relative;
    }

    /**
     * The container this file really is, or null.
     *
     * MP4 and friends carry "ftyp" as the second box header; WebM is a
     * Matroska stream, which starts with the EBML magic number.
     */
    public static function detect(string $path): ?string
    {
        $handle = @fopen($path, 'rb');

        if ($handle === false) {
            return null;
        }

        $head = fread($handle, 16);
        fclose($handle);

        if ($head === false || strlen($head) < 12) {
            return null;
        }

        if (substr($head, 4, 4) === 'ftyp') {
            return 'mp4';
        }

        if (str_starts_with($head, "\x1A\x45\xDF\xA3")) {
            return 'webm';
        }

        return null;
    }

    /** Whether a stored path is one of ours. */
    public static function isVideo(?string $path): bool
    {
        $extension = strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));

        return in_array($extension, self::extensions, true);
    }
}
