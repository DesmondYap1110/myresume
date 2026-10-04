<?php

/*
|--------------------------------------------------------------------------
| Public website languages
|--------------------------------------------------------------------------
|
| The languages a visitor can read a portfolio in. "default" is also the
| fallback: anything a member has not translated is shown as they wrote it,
| rather than left blank.
|
| Adding a language here is most of the work - it appears in the switcher and
| in Admin > Translation straight away. It still needs its own file in
| lang/<code>/site.php for the labels that are not member content.
|
*/

return [

    'default' => 'en',

    'supported' => [

        'en' => [
            'name' => 'English',
            'native' => 'English',
            'flag' => 'EN',
        ],

        'ms' => [
            'name' => 'Malay',
            'native' => 'Bahasa Melayu',
            'flag' => 'MS',
        ],

        'zh' => [
            'name' => 'Chinese',
            'native' => '中文',
            'flag' => '中',
        ],

    ],

    /*
    | Which fields each model offers for translation, and how to label them
    | in the admin. Everything else - names, dates, URLs, images - is the
    | same in every language and is not asked for.
    */
    'translatable' => [

        \App\Models\User::class => [
            'role' => 'Job title',
            'about' => 'About me',
        ],

        \App\Models\Experience::class => [
            'role' => 'Role',
            'company' => 'Company',
            'detail' => 'What you did',
        ],

        \App\Models\Education::class => [
            'institution' => 'Institution',
            'certificate' => 'Certificate',
            'achievement' => 'Achievement',
        ],

        \App\Models\Project::class => [
            'name' => 'Project name',
            'company' => 'Company',
            'detail' => 'Description',
        ],

        \App\Models\Service::class => [
            'title' => 'Title',
            'description' => 'Description',
        ],

        \App\Models\Skill::class => [
            'name' => 'Skill',
        ],

        \App\Models\Testimonial::class => [
            'position' => 'Position',
            'message' => 'What they said',
        ],

        \App\Models\Blog::class => [
            'title' => 'Title',
            'description' => 'Content',
        ],

    ],

];
