<?php

/*
|--------------------------------------------------------------------------
| Service icons
|--------------------------------------------------------------------------
|
| One icon per service, drawn with whatever icon set the template uses:
| Font Awesome (admin + Template 1), Themify (Template 2) and an inline
| SVG path (Template 3).
|
*/

return [

    'code' => [
        'label' => 'Code',
        'fa' => 'fas fa-code',
        'ti' => 'ti-layout',
        'svg' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
    ],

    'web' => [
        'label' => 'Web',
        'fa' => 'fas fa-desktop',
        'ti' => 'ti-desktop',
        'svg' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2',
    ],

    'mobile' => [
        'label' => 'Mobile app',
        'fa' => 'fas fa-mobile-alt',
        'ti' => 'ti-mobile',
        'svg' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
    ],

    'database' => [
        'label' => 'Database',
        'fa' => 'fas fa-database',
        'ti' => 'ti-server',
        'svg' => 'M4 7v10c0 2 3.6 3 8 3s8-1 8-3V7M4 7c0 2 3.6 3 8 3s8-1 8-3-3.6-3-8-3-8 1-8 3zm16 5c0 2-3.6 3-8 3s-8-1-8-3',
    ],

    'api' => [
        'label' => 'API / integration',
        'fa' => 'fas fa-plug',
        'ti' => 'ti-plug',
        'svg' => 'M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5M10.172 13.828a4 4 0 010-5.656l3-3a4 4 0 015.656 5.656l-1.5 1.5',
    ],

    'design' => [
        'label' => 'UI / design',
        'fa' => 'fas fa-paint-brush',
        'ti' => 'ti-paint-bucket',
        'svg' => 'M7 21a4 4 0 01-4-4c0-1.5 1-2.5 2-3l9-9a2.8 2.8 0 114 4l-9 9c-.5 1-1.5 2-3 2z',
    ],

    'security' => [
        'label' => 'Security',
        'fa' => 'fas fa-shield-alt',
        'ti' => 'ti-lock',
        'svg' => 'M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6l8-3zm-3.5 9l2.5 2.5 4.5-5',
    ],

    'cloud' => [
        'label' => 'Cloud / hosting',
        'fa' => 'fas fa-cloud',
        'ti' => 'ti-cloud',
        'svg' => 'M3 15a4 4 0 004 4h10a4 4 0 00.8-7.9A6 6 0 006.1 9.7 4 4 0 003 15z',
    ],

    'chart' => [
        'label' => 'Analytics',
        'fa' => 'fas fa-chart-line',
        'ti' => 'ti-bar-chart',
        'svg' => 'M3 20h18M5 16l4-5 4 3 6-8',
    ],

    'support' => [
        'label' => 'Support',
        'fa' => 'fas fa-headset',
        'ti' => 'ti-headphone-alt',
        'svg' => 'M4 17v-5a8 8 0 1116 0v5m-16 0a2 2 0 002 2h1a1 1 0 001-1v-4a1 1 0 00-1-1H4m16 0h-3a1 1 0 00-1 1v4a1 1 0 001 1h1a2 2 0 002-2',
    ],

    'rocket' => [
        'label' => 'Performance',
        'fa' => 'fas fa-rocket',
        'ti' => 'ti-rocket',
        'svg' => 'M13 10V3L4 14h7v7l9-11h-7z',
    ],

    'gear' => [
        'label' => 'Maintenance',
        'fa' => 'fas fa-cogs',
        'ti' => 'ti-settings',
        'svg' => 'M10.3 4.3a1 1 0 011-.8h1.4a1 1 0 011 .8l.2 1.4a6 6 0 011.5.9l1.3-.6a1 1 0 011.2.4l.7 1.2a1 1 0 01-.2 1.3l-1.1.9a6 6 0 010 1.7l1.1.9a1 1 0 01.2 1.3l-.7 1.2a1 1 0 01-1.2.4l-1.3-.6a6 6 0 01-1.5.9l-.2 1.4a1 1 0 01-1 .8h-1.4a1 1 0 01-1-.8l-.2-1.4a6 6 0 01-1.5-.9l-1.3.6a1 1 0 01-1.2-.4l-.7-1.2a1 1 0 01.2-1.3l1.1-.9a6 6 0 010-1.7l-1.1-.9a1 1 0 01-.2-1.3l.7-1.2a1 1 0 011.2-.4l1.3.6a6 6 0 011.5-.9zM12 14.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z',
    ],

];
