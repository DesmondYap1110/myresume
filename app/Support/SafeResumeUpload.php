<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Stores a resume PDF where the web server cannot reach it directly.
 *
 * Images can be redrawn to strip anything hidden in them (see
 * SafeImageUpload); a PDF cannot, so instead it is checked and then kept out
 * of the web root. It is only ever sent back as a download, never rendered
 * inside the site.
 */
class SafeResumeUpload
{
    /** Relative to storage/app. */
    public const directory = 'resumes';

    public const max_kb = 5120;

    /**
     * Features a CV has no use for, and that malicious PDFs rely on. This is a
     * best-effort check: names inside compressed object streams are not seen.
     */
    private const blocked = ['/JavaScript', '/JS', '/Launch', '/EmbeddedFile', '/RichMedia', '/XFA'];

    /**
     * @return array{path: string, name: string}
     */
    public static function store(UploadedFile $file, string $field = 'resume'): array
    {
        $fail = fn (string $message) => throw ValidationException::withMessages([$field => $message]);

        if (!$file->isValid()) {
            $fail('The upload did not finish. Please try again.');
        }

        if (strtolower($file->getClientOriginalExtension()) !== 'pdf') {
            $fail('Please upload your resume as a PDF file.');
        }

        if ($file->getSize() > self::max_kb * 1024) {
            $fail('The resume must be 5 MB or smaller.');
        }

        // What the file really is, not what the browser says it is.
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file->getRealPath());

        if ($mime !== 'application/pdf') {
            $fail('That file is not a real PDF.');
        }

        $contents = (string) file_get_contents($file->getRealPath());

        if (!str_starts_with(ltrim($contents), '%PDF-')) {
            $fail('That file is not a real PDF.');
        }

        foreach (self::blocked as $name) {
            // Match the whole name, so /JS does not trip on /JSON-like text.
            if (preg_match('#'.preg_quote($name, '#').'(?![A-Za-z])#', $contents)) {
                $fail('This PDF contains scripts or embedded files, which a resume should not have. Export it again as a plain PDF.');
            }
        }

        $relative = self::directory.'/'.Str::random(40).'.pdf';
        $target = storage_path('app/'.$relative);

        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0755, true);
        }

        if (!copy($file->getRealPath(), $target)) {
            $fail('The resume could not be saved. Please try again.');
        }

        return [
            'path' => $relative,
            'name' => static::displayName($file->getClientOriginalName()),
        ];
    }

    /** Removes a stored resume. Only ever touches files inside resumes/. */
    public static function delete(?string $relative): void
    {
        if (blank($relative) || !preg_match('#^'.self::directory.'/[A-Za-z0-9]{40}\.pdf$#', $relative)) {
            return;
        }

        $path = storage_path('app/'.$relative);

        if (is_file($path)) {
            @unlink($path);
        }
    }

    /** The original name, tidied for showing in the admin. */
    private static function displayName(string $name): string
    {
        $name = preg_replace('/[^\w\s.\-()]+/u', '', $name) ?: 'resume.pdf';

        return Str::limit($name, 120, '');
    }
}
