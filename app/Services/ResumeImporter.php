<?php

namespace App\Services;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Writes reviewed resume data into the owner's modules.
 *
 * Nothing is written until the user presses Import, and existing rows are
 * matched rather than duplicated (same company + role, same institution).
 */
class ResumeImporter
{
    public function __construct(private User $user)
    {
    }

    /**
     * @param  array  $data      the structured data from ResumeAssistant::extract()
     * @param  array  $sections  which parts to import: profile, experience, education, services
     * @return array<string, int> what was written
     */
    public function import(array $data, array $sections): array
    {
        $done = ['profile' => 0, 'experience' => 0, 'education' => 0, 'services' => 0];
        $userId = (string) $this->user->id;
        $now = now();

        DB::transaction(function () use ($data, $sections, $userId, $now, &$done) {

            if (in_array('profile', $sections, true) && !empty($data['profile'])) {
                $profile = $data['profile'];
                $fields = array_filter([
                    'name' => $this->clean($profile['name'] ?? null, 255),
                    'role' => $this->clean($profile['role'] ?? null, 255),
                    'address' => $this->clean($profile['address'] ?? null, 255),
                    'phone' => $this->digits($profile['phone'] ?? null),
                    'linkedIn_url' => $this->url($profile['linkedIn_url'] ?? null),
                    'about' => $this->clean($profile['about'] ?? null, 5000),
                ], fn ($value) => filled($value));

                // The email is the login, so it is never overwritten here.
                if ($fields) {
                    DB::table('users')->where('id', $this->user->id)->update($fields + ['updated_at' => $now]);
                    $done['profile'] = count($fields);
                }
            }

            if (in_array('experience', $sections, true)) {
                foreach ($data['experience'] ?? [] as $job) {
                    $company = $this->clean($job['company'] ?? null, 255);
                    $role = $this->clean($job['role'] ?? null, 255);
                    $start = $this->period($job['start_date'] ?? null);

                    if (blank($company) || blank($role) || blank($start)) {
                        continue;
                    }

                    DB::table('experience')->updateOrInsert(
                        ['user_id' => $userId, 'company' => $company, 'role' => $role],
                        [
                            'start_date' => $start,
                            'end_date' => $this->period($job['end_date'] ?? null),
                            'detail' => $this->bulletHtml($job['bullets'] ?? []),
                            'status' => 1,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                    );
                    $done['experience']++;
                }
            }

            if (in_array('education', $sections, true)) {
                foreach ($data['education'] ?? [] as $edu) {
                    $institution = $this->clean($edu['institution'] ?? null, 255);

                    if (blank($institution)) {
                        continue;
                    }

                    $year = $edu['year'] ?? null;
                    $year = (is_numeric($year) && $year > 1900 && $year <= (int) date('Y') + 10) ? (int) $year : null;

                    DB::table('education')->updateOrInsert(
                        ['user_id' => $userId, 'institution' => $institution],
                        [
                            'certificate' => $this->clean($edu['certificate'] ?? null, 255) ?: 'Qualification',
                            'achievement' => $this->clean($edu['achievement'] ?? null, 2000),
                            'year' => $year,
                            'status' => 1,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                    );
                    $done['education']++;
                }
            }

            if (in_array('services', $sections, true)) {
                $icons = array_keys((array) config('service_icons', []));
                $order = 0;

                foreach ($data['services'] ?? [] as $service) {
                    $title = $this->clean($service['title'] ?? null, 255);

                    if (blank($title)) {
                        continue;
                    }

                    $icon = in_array($service['icon'] ?? '', $icons, true) ? $service['icon'] : ($icons[0] ?? 'code');

                    DB::table('service')->updateOrInsert(
                        ['user_id' => $userId, 'title' => $title],
                        [
                            'description' => $this->clean($service['description'] ?? null, 1000) ?: $title,
                            'icon' => $icon,
                            'sort_order' => $order++,
                            'status' => 1,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                    );
                    $done['services']++;
                }
            }
        });

        return $done;
    }

    /** Plain text only — the model's output is never trusted as HTML. */
    private function clean(?string $value, int $limit): ?string
    {
        $value = trim(preg_replace('/\s+/', ' ', strip_tags((string) $value)));

        return $value === '' ? null : mb_substr($value, 0, $limit);
    }

    private function digits(?string $value): ?string
    {
        $value = preg_replace('/\D+/', '', (string) $value);

        return strlen($value) >= 7 ? $value : null;
    }

    private function url(?string $value): ?string
    {
        $value = trim((string) $value);

        return filter_var($value, FILTER_VALIDATE_URL) ? mb_substr($value, 0, 255) : null;
    }

    /** "2024-05" or "2015"; anything else is dropped. */
    private function period(?string $value): ?string
    {
        $value = trim((string) $value);

        if (preg_match('/^\d{4}-\d{2}$/', $value) || preg_match('/^\d{4}$/', $value)) {
            return $value;
        }

        if (preg_match('/^(\d{4})-(\d{2})-\d{2}$/', $value, $m)) {
            return $m[1].'-'.$m[2];
        }

        return null;
    }

    /** Bullets as an escaped <ul>, the same shape the Blog/Experience editor uses. */
    private function bulletHtml(array $bullets): string
    {
        $items = array_values(array_filter(array_map(fn ($b) => $this->clean($b, 500), $bullets)));

        if (!$items) {
            return '';
        }

        return "<ul>\n".implode("\n", array_map(fn ($b) => '<li>'.e($b).'</li>', $items))."\n</ul>";
    }
}
