<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

/**
 * Takes the "Other languages" tabs off a module's own form and stores them
 * on the record just saved.
 *
 * The model decides what it will accept - unknown languages and fields are
 * dropped there - so a controller only has to hand the input over.
 */
trait SavesTranslations
{
    protected function storeTranslations(Request $request, $model): void
    {
        if (!$model || !method_exists($model, 'saveTranslations')) {
            return;
        }

        foreach ((array) $request->input('translations', []) as $locale => $fields) {
            if (is_string($locale) && is_array($fields)) {
                $model->saveTranslations($locale, $fields);
            }
        }
    }

    /** Rules to merge into a module's own validate() call. */
    protected function translationRules(): array
    {
        return [
            'translations' => ['array'],
            'translations.*' => ['array'],
            'translations.*.*' => ['nullable', 'string', 'max:20000'],
        ];
    }
}
