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

                return static::tidy($text.static::links($path));
            } catch (\Throwable $e) {
                Log::warning('Could not read PDF text', ['error' => $e->getMessage()]);

                return null;
            }
        }

        // Images need a model that can see them (Claude).
        return null;
    }

    /**
     * Resumes usually hide their LinkedIn and GitHub addresses behind the word
     * "LinkedIn", so the visible text never carries them. The link targets sit
     * in the PDF's annotations, which are readable from the raw file.
     */
    private static function links(string $path): string
    {
        if (!preg_match_all('~/URI\s*\(\s*((?:https?://|mailto:)[^)\s]{4,300})\s*\)~', (string) file_get_contents($path), $found)) {
            return '';
        }

        $links = array_slice(array_unique($found[1]), 0, 20);

        return "\n\nLinks in this document:\n".implode("\n", $links);
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
