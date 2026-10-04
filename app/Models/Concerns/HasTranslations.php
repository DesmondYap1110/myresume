<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\App;

/**
 * Lets a model answer in the language the page is being read in.
 *
 * The other languages live in the row's own "translations" JSON column,
 * shaped locale => field => text. Which fields are on offer comes from
 * config/locales.php, so adding a language or a field is a config change,
 * not a migration.
 *
 * Use $model->t('detail') wherever the public site used $model->detail. With
 * nothing translated - or in the default language - it returns exactly what
 * the member wrote, so this changes nothing until somebody translates
 * something.
 */
trait HasTranslations
{
    /** The fields this model offers, from config/locales.php. */
    public static function translatableFields(): array
    {
        return (array) (config('locales.translatable.'.static::class) ?? []);
    }

    public function initializeHasTranslations(): void
    {
        $this->casts['translations'] = 'array';

        /*
         * Only saveTranslations() writes this column. These models guard
         * nothing, so without closing it a crafted "translations[...]" field
         * would ride along on any create() or update() taking request input.
         */
        $this->fillable = array_values(array_diff($this->fillable ?? [], ['translations']));

        if (!in_array('translations', $this->guarded ?? [], true)) {
            $this->guarded = array_merge($this->guarded ?? [], ['translations']);
        }
    }

    /** Everything stored, as locale => field => text. */
    public function translationMap(): array
    {
        $stored = $this->translations;

        if (is_string($stored)) {
            $stored = json_decode($stored, true);
        }

        return is_array($stored) ? $stored : [];
    }

    /** One field in the current language, falling back to the original. */
    public function t(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?: App::getLocale();
        $original = $this->{$field};

        if ($locale === config('locales.default') || !array_key_exists($field, static::translatableFields())) {
            return $original;
        }

        $value = $this->translationMap()[$locale][$field] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : $original;
    }

    /** What has been written for this record in one language. */
    public function translationsFor(string $locale): array
    {
        return (array) ($this->translationMap()[$locale] ?? []);
    }

    /**
     * Replace this record's fields for one language.
     *
     * Blank values are removed rather than stored, so clearing a box puts
     * that field back to the member's original wording. A language left with
     * nothing drops out entirely, and so does the column.
     */
    public function saveTranslations(string $locale, array $fields): void
    {
        // Posted from a form, so neither the language nor the field names
        // are trusted: both must be ones we publish.
        if (!array_key_exists($locale, (array) config('locales.supported', []))
            || $locale === config('locales.default')) {
            return;
        }

        $map = $this->translationMap();
        $allowed = array_intersect_key($fields, static::translatableFields());

        foreach ($allowed as $field => $value) {
            $value = is_string($value) ? trim($value) : '';

            if ($value === '') {
                unset($map[$locale][$field]);
            } else {
                $map[$locale][$field] = $value;
            }
        }

        if (empty($map[$locale])) {
            unset($map[$locale]);
        }

        $this->translations = $map ?: null;
        $this->save();
    }
}
