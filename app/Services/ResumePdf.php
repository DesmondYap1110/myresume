<?php

namespace App\Services;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use App\Support\Branding;
use App\Support\Period;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * A resume PDF built from the owner's portfolio data: profile, experience,
 * education, projects and services. Nothing is uploaded or stored by hand,
 * so it is always as current as the website.
 *
 * Rendering is the slow part, so the PDF is cached against a hash of its
 * HTML: any change to the data produces a new file, identical requests
 * reuse the last one.
 */
class ResumePdf
{
    private ?string $html = null;

    public function __construct(private User $user)
    {
    }

    public static function for(User $user): self
    {
        return new self($user);
    }

    /** Everything the template needs, already cleaned to plain text. */
    public function data(): array
    {
        $user = $this->user;
        [$summary, $skills] = $this->splitSkills($this->plain($user->about));

        $colors = Branding::websiteColors($user, $user->websiteTemplate());
        $accent = $colors['accent'] ?? '#FFD700';

        return [
            'name' => (string) $user->name,
            'role' => (string) $user->role,
            'email' => (string) $user->email,
            'phone' => $this->phone($user->phone),
            'address' => (string) $user->address,
            'linkedin' => $this->shortUrl($user->linkedIn_url),
            'linkedinUrl' => (string) $user->linkedIn_url,
            'website' => route('front.show', $user->routeKey()),
            'photo' => $this->photo(),
            'summary' => $summary,
            'skills' => $skills,
            'experience' => Experience::getExperienceByUserid($user->id)->map(fn ($job) => [
                'role' => $this->plain($job->role),
                'company' => $this->plain($job->company),
                'period' => Period::label($job->start_date, $job->end_date),
                'bullets' => $this->bullets($job->detail),
                'text' => $this->plain($job->detail),
            ])->all(),
            'education' => Education::getEducationByUserid($user->id)->map(fn ($edu) => [
                'certificate' => $this->plain($edu->certificate),
                'institution' => $this->plain($edu->institution),
                'year' => $edu->year,
                'achievement' => $this->plain($edu->achievement),
            ])->all(),
            'projects' => Project::getProjectByUserid($user->id)->map(fn ($item) => [
                'name' => $this->plain($item->name),
                'company' => $this->plain($item->company),
                'period' => Period::label($item->start_date, $item->end_date),
                'text' => $this->plain($item->detail),
            ])->all(),
            'services' => Service::getServiceByUserid($user->id)->map(fn ($item) => [
                'title' => $this->plain($item->title),
                'description' => $this->plain($item->description),
            ])->all(),
            'accent' => $accent,
            // Bright accents (gold) are unreadable as text on white.
            'ink' => $this->isBright($accent) ? Branding::darken($accent, 45) : $accent,
            'generated' => now()->format('F Y'),
        ];
    }

    public function html(): string
    {
        return $this->html ??= view('pdf.resume', $this->data())->render();
    }

    /** The PDF bytes, from cache when the content has not changed. */
    public function output(): string
    {
        $html = $this->html();

        return Cache::remember('resume-pdf:'.$this->user->id.':'.md5($html), now()->addDay(), function () use ($html) {
            return Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    // Nothing is fetched from outside; the photo is inlined.
                    'isRemoteEnabled' => false,
                    'isPhpEnabled' => false,
                    'isJavascriptEnabled' => false,
                    'chroot' => public_path(),
                ])
                ->output();
        });
    }

    /** $disposition: 'inline' to view in the browser, 'attachment' to save. */
    public function response(string $disposition = 'attachment'): Response
    {
        $name = $this->user->resumeDownloadName();

        return response($this->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => ($disposition === 'inline' ? 'inline' : 'attachment').'; filename="'.$name.'"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ]);
    }

    // ── helpers ─────────────────────────────────────────────────────────

    private function plain($html): string
    {
        $text = str_replace(['</p>', '</li>', '<br>', '<br/>', '<br />'], ' ', (string) $html);

        return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    /** List items from the admin editor's HTML, as plain strings. */
    private function bullets($html): array
    {
        preg_match_all('#<li[^>]*>(.*?)</li>#is', (string) $html, $m);

        return array_values(array_filter(array_map(fn ($item) => $this->plain($item), $m[1])));
    }

    /**
     * About texts often end with "Skills: HTML, CSS, ...". Pull that into a
     * list of its own and keep the rest as the summary.
     *
     * @return array{0: string, 1: array<int, string>}
     */
    private function splitSkills(string $about): array
    {
        // "Skills:", "Key Skills:", "Top Skills:" (LinkedIn's wording) and so on.
        if (!preg_match('/\b(?:(?:Top|Key|Core|Technical)\s+)?Skills?\s*:\s*(.+)$/iu', $about, $m, PREG_OFFSET_CAPTURE)) {
            return [$about, []];
        }

        $skills = collect(preg_split('/\s*[,;•|]\s*/u', rtrim($m[1][0], ". \t")))
            ->map(fn ($s) => trim($s))
            ->filter(fn ($s) => $s !== '' && mb_strlen($s) <= 40)
            ->unique(fn ($s) => mb_strtolower($s))
            ->take(24)
            ->values()
            ->all();

        $summary = trim(mb_substr($about, 0, $m[0][1]));

        return [$summary !== '' ? $summary : $about, $skills];
    }

    private function phone($phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        return $digits === '' ? '' : '+'.$digits;
    }

    private function shortUrl($url): string
    {
        $url = trim((string) $url);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        return rtrim(preg_replace('#^https?://(www\.)?#i', '', $url), '/');
    }

    private function isBright(string $hex): bool
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = preg_replace('/(.)/', '$1$1', $hex);
        [$r, $g, $b] = array_map('hexdec', str_split(str_pad($hex, 6, '0'), 2));

        return (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255 > 0.6;
    }

    /**
     * The profile photo as a round PNG data URI. dompdf does not clip images
     * to a border-radius reliably, so the circle is cut here with GD. Only
     * files inside public/ are read.
     */
    private function photo(): ?string
    {
        $raw = trim((string) $this->user->getRawOriginal('image'));

        if ($raw === '') {
            return null;
        }

        // Older rows hold a full URL; keep only the part under /uploads/.
        if (preg_match('#^(https?:)?//#i', $raw)) {
            $path = (string) parse_url($raw, PHP_URL_PATH);
            $at = strpos($path, '/uploads/');
            if ($at === false) return null;
            $raw = substr($path, $at + 1);
        }

        $root = realpath(public_path());
        $file = realpath(public_path(ltrim($raw, '/')));

        if (!$root || !$file || !str_starts_with($file, $root.DIRECTORY_SEPARATOR) || !is_file($file)) {
            return null;
        }

        try {
            $source = @imagecreatefromstring((string) file_get_contents($file));
            if (!$source) return null;

            $size = 240;
            $w = imagesx($source);
            $h = imagesy($source);
            $side = min($w, $h);

            $square = imagecreatetruecolor($size, $size);
            // Centre crop, nudged up a little so the top of the head stays in.
            imagecopyresampled($square, $source, 0, 0, (int) (($w - $side) / 2), (int) max(0, ($h - $side) * .12), $size, $size, $side, $side);

            $round = imagecreatetruecolor($size, $size);
            imagesavealpha($round, true);
            imagealphablending($round, false);
            $clear = imagecolorallocatealpha($round, 0, 0, 0, 127);
            imagefill($round, 0, 0, $clear);

            $r = $size / 2;
            for ($y = 0; $y < $size; $y++) {
                for ($x = 0; $x < $size; $x++) {
                    $d = sqrt(($x - $r + .5) ** 2 + ($y - $r + .5) ** 2);
                    if ($d <= $r) {
                        // A one-pixel soft edge so the circle isn't jagged.
                        $alpha = $d > $r - 1 ? (int) round(127 * ($d - ($r - 1))) : 0;
                        $rgb = imagecolorat($square, $x, $y);
                        imagesetpixel($round, $x, $y, imagecolorallocatealpha($round, ($rgb >> 16) & 255, ($rgb >> 8) & 255, $rgb & 255, $alpha));
                    }
                }
            }

            ob_start();
            imagepng($round);

            return 'data:image/png;base64,'.base64_encode((string) ob_get_clean());
        } catch (\Throwable $e) {
            return null;
        }
    }
}
