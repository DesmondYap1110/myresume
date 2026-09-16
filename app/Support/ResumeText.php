<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

/**
 * Turns an uploaded resume into plain text for models that cannot read files
 * themselves (everything except Claude).
 */
class ResumeText
{
    /** Characters of resume text sent to the model. */
    public const limit = 60000;

    public static function fromFile(UploadedFile $file): ?string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        if ($extension === 'txt') {
            return static::tidy((string) file_get_contents($path));
        }

        if ($extension === 'pdf') {
            try {
                $text = (new Parser())->parseFile($path)->getText();

                return static::tidy($text);
            } catch (\Throwable $e) {
                Log::warning('Could not read PDF text', ['error' => $e->getMessage()]);

                return null;
            }
        }

        // Images need a model that can see them (Claude).
        return null;
    }

    private static function tidy(string $text): ?string
    {
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', $text);
        $text = preg_replace("/[ \t]+/", ' ', $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);
        $text = trim($text);

        return $text === '' ? null : mb_substr($text, 0, self::limit);
    }
}
