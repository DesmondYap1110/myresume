<?php

/*
|--------------------------------------------------------------------------
| Website templates
|--------------------------------------------------------------------------
|
| The public portfolio designs an owner can pick under Account Setting.
| Each key matches a view folder: resources/views/website/{key}/index.blade.php.
|
*/

return [

    'default' => 'template1',

    'templates' => [

        'template1' => [
            'name' => 'Template 1 - Tech Dark',
            'description' => 'Dark, animated one-page portfolio. Uses the colours from Theme Setting.',
            'preview' => 'assets/admin/img/templates/template1.jpg',
        ],

        'template2' => [
            'name' => 'Template 2 - Thomson',
            'description' => 'Clean, light minimal portfolio with a separate page for each blog post.',
            'preview' => 'assets/admin/img/templates/template2.jpg',
            // MIT licensed - see public/assets/website/template2/LICENSE.txt
            'credit' => 'Thomson by Themefisher, distributed by ThemeWagon',
        ],

        'template3' => [
            'name' => 'Template 3 - Folio',
            'description' => 'Modern portfolio with a light/dark switch, services and client testimonials.',
            'preview' => 'assets/admin/img/templates/template3.jpg',
            // MIT licensed - Folio by Laurent Begey, distributed by ThemeWagon.
            'credit' => 'Folio by Laurent Begey, distributed by ThemeWagon',
        ],

    ],

];
