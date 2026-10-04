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
        'fa4' => 'fa fa-code',   // the website uses Font Awesome 4
        'ti' => 'ti-layout',
        'svg' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
    ],

    'web' => [
        'label' => 'Web',
        'fa' => 'fas fa-desktop',
        'fa4' => 'fa fa-desktop',   // the website uses Font Awesome 4
        'ti' => 'ti-desktop',
        'svg' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2',
    ],

    'mobile' => [
        'label' => 'Mobile',
        'fa' => 'fas fa-mobile-alt',
        'fa4' => 'fa fa-mobile',   // the website uses Font Awesome 4
        'ti' => 'ti-mobile',
        'svg' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
    ],

    'database' => [
        'label' => 'Database',
        'fa' => 'fas fa-database',
        'fa4' => 'fa fa-database',   // the website uses Font Awesome 4
        'ti' => 'ti-server',
        'svg' => 'M4 7v10c0 2 3.6 3 8 3s8-1 8-3V7M4 7c0 2 3.6 3 8 3s8-1 8-3-3.6-3-8-3-8 1-8 3zm16 5c0 2-3.6 3-8 3s-8-1-8-3',
    ],

    'api' => [
        'label' => 'API',
        'fa' => 'fas fa-plug',
        'fa4' => 'fa fa-plug',   // the website uses Font Awesome 4
        'ti' => 'ti-plug',
        'svg' => 'M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5M10.172 13.828a4 4 0 010-5.656l3-3a4 4 0 015.656 5.656l-1.5 1.5',
    ],

    'design' => [
        'label' => 'Design',
        'fa' => 'fas fa-paint-brush',
        'fa4' => 'fa fa-paint-brush',   // the website uses Font Awesome 4
        'ti' => 'ti-paint-bucket',
        'svg' => 'M7 21a4 4 0 01-4-4c0-1.5 1-2.5 2-3l9-9a2.8 2.8 0 114 4l-9 9c-.5 1-1.5 2-3 2z',
    ],

    'security' => [
        'label' => 'Security',
        'fa' => 'fas fa-shield-alt',
        'fa4' => 'fa fa-shield',   // the website uses Font Awesome 4
        'ti' => 'ti-lock',
        'svg' => 'M12 3l8 3v6c0 4.5-3.4 8.3-8 9-4.6-.7-8-4.5-8-9V6l8-3zm-3.5 9l2.5 2.5 4.5-5',
    ],

    'cloud' => [
        'label' => 'Cloud',
        'fa' => 'fas fa-cloud',
        'fa4' => 'fa fa-cloud',   // the website uses Font Awesome 4
        'ti' => 'ti-cloud',
        'svg' => 'M3 15a4 4 0 004 4h10a4 4 0 00.8-7.9A6 6 0 006.1 9.7 4 4 0 003 15z',
    ],

    'chart' => [
        'label' => 'Analytics',
        'fa' => 'fas fa-chart-line',
        'fa4' => 'fa fa-line-chart',   // the website uses Font Awesome 4
        'ti' => 'ti-bar-chart',
        'svg' => 'M3 20h18M5 16l4-5 4 3 6-8',
    ],

    'support' => [
        'label' => 'Support',
        'fa' => 'fas fa-headset',
        'fa4' => 'fa fa-headphones',   // the website uses Font Awesome 4
        'ti' => 'ti-headphone-alt',
        'svg' => 'M4 17v-5a8 8 0 1116 0v5m-16 0a2 2 0 002 2h1a1 1 0 001-1v-4a1 1 0 00-1-1H4m16 0h-3a1 1 0 00-1 1v4a1 1 0 001 1h1a2 2 0 002-2',
    ],

    'rocket' => [
        'label' => 'Performance',
        'fa' => 'fas fa-rocket',
        'fa4' => 'fa fa-rocket',   // the website uses Font Awesome 4
        'ti' => 'ti-rocket',
        'svg' => 'M13 10V3L4 14h7v7l9-11h-7z',
    ],

    'gear' => [
        'label' => 'Maintenance',
        'fa' => 'fas fa-cogs',
        'fa4' => 'fa fa-cogs',   // the website uses Font Awesome 4
        'ti' => 'ti-settings',
        'svg' => 'M10.3 4.3a1 1 0 011-.8h1.4a1 1 0 011 .8l.2 1.4a6 6 0 011.5.9l1.3-.6a1 1 0 011.2.4l.7 1.2a1 1 0 01-.2 1.3l-1.1.9a6 6 0 010 1.7l1.1.9a1 1 0 01.2 1.3l-.7 1.2a1 1 0 01-1.2.4l-1.3-.6a6 6 0 01-1.5.9l-.2 1.4a1 1 0 01-1 .8h-1.4a1 1 0 01-1-.8l-.2-1.4a6 6 0 01-1.5-.9l-1.3.6a1 1 0 01-1.2-.4l-.7-1.2a1 1 0 01.2-1.3l1.1-.9a6 6 0 010-1.7l-1.1-.9a1 1 0 01-.2-1.3l.7-1.2a1 1 0 011.2-.4l1.3.6a6 6 0 011.5-.9zM12 14.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z',
    ],


    'health' => [
        'label' => 'Healthcare',
        'fa' => 'fas fa-stethoscope',
        'fa4' => 'fa fa-stethoscope',
        'ti' => 'ti-heart',
        'svg' => 'M6 3v6a6 6 0 0012 0V3M9 3H5m8 0h4m-5 18a4 4 0 004-4v-2',
    ],

    'dental' => [
        'label' => 'Dental',
        'fa' => 'fas fa-tooth',
        'fa4' => 'fa fa-medkit',
        'ti' => 'ti-heart-broken',
        'svg' => 'M12 4c-2 0-3-1-5 0s-2 4-1 7 1 9 3 9 2-5 3-5 1 5 3 5 2-6 3-9 1-6-1-7-3 0-5 0z',
    ],

    'wellness' => [
        'label' => 'Fitness',
        'fa' => 'fas fa-dumbbell',
        'fa4' => 'fa fa-heartbeat',
        'ti' => 'ti-pulse',
        'svg' => 'M6 6v12M18 6v12M3 9v6m18-6v6M6 12h12',
    ],

    'therapy' => [
        'label' => 'Therapy',
        'fa' => 'fas fa-hands-helping',
        'fa4' => 'fa fa-handshake-o',
        'ti' => 'ti-support',
        'svg' => 'M12 21a9 9 0 110-18 9 9 0 010 18zm-3-9a3 3 0 006 0',
    ],

    'content' => [
        'label' => 'Content',
        'fa' => 'fas fa-video',
        'fa4' => 'fa fa-video-camera',
        'ti' => 'ti-video-camera',
        'svg' => 'M15 10l5-3v10l-5-3v-4zM3 7a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z',
    ],

    'photo' => [
        'label' => 'Photography',
        'fa' => 'fas fa-camera',
        'fa4' => 'fa fa-camera',
        'ti' => 'ti-camera',
        'svg' => 'M3 9a2 2 0 012-2h2l2-2h6l2 2h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm9 9a4 4 0 100-8 4 4 0 000 8z',
    ],

    'podcast' => [
        'label' => 'Podcast',
        'fa' => 'fas fa-microphone',
        'fa4' => 'fa fa-microphone',
        'ti' => 'ti-microphone',
        'svg' => 'M12 15a3 3 0 003-3V6a3 3 0 00-6 0v6a3 3 0 003 3zm-7-3a7 7 0 0014 0M12 19v3',
    ],

    'writing' => [
        'label' => 'Writing',
        'fa' => 'fas fa-pen-nib',
        'fa4' => 'fa fa-pencil',
        'ti' => 'ti-write',
        'svg' => 'M4 20l4-1 10-10a2.8 2.8 0 10-4-4L4 15l-1 4zM13 6l4 4',
    ],

    'social' => [
        'label' => 'Social',
        'fa' => 'fas fa-hashtag',
        'fa4' => 'fa fa-hashtag',
        'ti' => 'ti-announcement',
        'svg' => 'M5 9h14M5 15h14M10 3L8 21M16 3l-2 18',
    ],

    'marketing' => [
        'label' => 'Marketing',
        'fa' => 'fas fa-bullhorn',
        'fa4' => 'fa fa-bullhorn',
        'ti' => 'ti-announcement',
        'svg' => 'M3 11v2a1 1 0 001 1h2l4 4V6L6 10H4a1 1 0 00-1 1zm13-4a6 6 0 010 10',
    ],

    'teaching' => [
        'label' => 'Teaching',
        'fa' => 'fas fa-chalkboard-teacher',
        'fa4' => 'fa fa-graduation-cap',
        'ti' => 'ti-blackboard',
        'svg' => 'M12 4L2 9l10 5 10-5-10-5zm0 10v6m-6-7v4c0 1.5 2.7 3 6 3s6-1.5 6-3v-4',
    ],

    'legal' => [
        'label' => 'Legal',
        'fa' => 'fas fa-balance-scale',
        'fa4' => 'fa fa-balance-scale',
        'ti' => 'ti-ruler-alt',
        'svg' => 'M12 3v18M5 7h14M7 7l-3 7h6l-3-7zm10 0l-3 7h6l-3-7zM8 21h8',
    ],

    'finance' => [
        'label' => 'Finance',
        'fa' => 'fas fa-calculator',
        'fa4' => 'fa fa-calculator',
        'ti' => 'ti-wallet',
        'svg' => 'M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm1 4h8M8 11h2m4 0h2m-6 4h2m4 0h2',
    ],

    'consulting' => [
        'label' => 'Consulting',
        'fa' => 'fas fa-briefcase',
        'fa4' => 'fa fa-briefcase',
        'ti' => 'ti-briefcase',
        'svg' => 'M3 9a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm6-2V5a2 2 0 012-2h2a2 2 0 012 2v2',
    ],

    'property' => [
        'label' => 'Property',
        'fa' => 'fas fa-home',
        'fa4' => 'fa fa-home',
        'ti' => 'ti-home',
        'svg' => 'M3 11l9-8 9 8M5 10v10h5v-6h4v6h5V10',
    ],

    'food' => [
        'label' => 'Catering',
        'fa' => 'fas fa-utensils',
        'fa4' => 'fa fa-cutlery',
        'ti' => 'ti-cup',
        'svg' => 'M7 3v8a2 2 0 002 2v8M7 3v4m3-4v4m7-4c1.5 0 2 3 2 6s-1 4-2 4v8',
    ],

    'beauty' => [
        'label' => 'Beauty',
        'fa' => 'fas fa-cut',
        'fa4' => 'fa fa-scissors',
        'ti' => 'ti-cut',
        'svg' => 'M6 6a2 2 0 104 0 2 2 0 00-4 0zm0 12a2 2 0 104 0 2 2 0 00-4 0zM9 9l11 9M9 15l11-9',
    ],

    'events' => [
        'label' => 'Events',
        'fa' => 'fas fa-calendar-check',
        'fa4' => 'fa fa-calendar',
        'ti' => 'ti-calendar',
        'svg' => 'M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1zm3-2v4m8-4v4M4 10h16m-10 5l2 2 4-4',
    ],

    'music' => [
        'label' => 'Music',
        'fa' => 'fas fa-music',
        'fa4' => 'fa fa-music',
        'ti' => 'ti-music-alt',
        'svg' => 'M9 18V6l10-2v12M9 18a2 2 0 11-4 0 2 2 0 014 0zm10-2a2 2 0 11-4 0 2 2 0 014 0z',
    ],

    'language' => [
        'label' => 'Translation',
        'fa' => 'fas fa-language',
        'fa4' => 'fa fa-language',
        'ti' => 'ti-world',
        'svg' => 'M4 5h10M9 3v2c0 5-2 8-5 10m2-4c0 3 3 5 7 6m2-6l4 10m-6 0h8',
    ],

    'logistics' => [
        'label' => 'Logistics',
        'fa' => 'fas fa-truck',
        'fa4' => 'fa fa-truck',
        'ti' => 'ti-truck',
        'svg' => 'M3 7h10v9H3V7zm10 3h4l3 3v3h-7v-6zM7 19a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm10 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z',
    ],

    'repair' => [
        'label' => 'Repair',
        'fa' => 'fas fa-wrench',
        'fa4' => 'fa fa-wrench',
        'ti' => 'ti-settings',
        'svg' => 'M14.7 6.3a4 4 0 00-5.4 5.4L4 17v3h3l5.3-5.3a4 4 0 005.4-5.4l-2.5 2.5-2.1-2.1 2.6-2.4z',
    ],

    'pets' => [
        'label' => 'Pets',
        'fa' => 'fas fa-paw',
        'fa4' => 'fa fa-paw',
        'ti' => 'ti-heart',
        'svg' => 'M12 14c-3 0-5 2-5 4a2 2 0 002 2h6a2 2 0 002-2c0-2-2-4-5-4zM6 8a2 2 0 100-4 2 2 0 000 4zm12 0a2 2 0 100-4 2 2 0 000 4zM9.5 6a2 2 0 100-4 2 2 0 000 4zm5 0a2 2 0 100-4 2 2 0 000 4z',
    ],

    'eco' => [
        'label' => 'Eco',
        'fa' => 'fas fa-leaf',
        'fa4' => 'fa fa-leaf',
        'ti' => 'ti-flag-alt',
        'svg' => 'M4 20c0-8 6-14 16-14 0 10-6 15-14 15M4 20c2-4 5-6 8-7',
    ],
];
