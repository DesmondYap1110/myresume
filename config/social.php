<?php

/*
|--------------------------------------------------------------------------
| Social networks
|--------------------------------------------------------------------------
|
| The networks a member can link to from their website, in the order they
| appear in Profile > Social Links and on the public site.
|
| Adding one here is all that is needed - it shows up in the form and on the
| website straight away, with no migration, because the links live in a JSON
| column on the user.
|
|   icon   Font Awesome class, already loaded by both the admin and the site
|   brand  the network's own colour, for the icon
|   host   what a valid link must end in; anything else is rejected, so a
|          member cannot be talked into pasting a lookalike address
|
*/

return [

    'networks' => [

        'facebook' => [
            'label' => 'Facebook',
            'icon' => 'fab fa-facebook',
            'brand' => '#1877F2',
            'placeholder' => 'https://www.facebook.com/yourname',
            'host' => ['facebook.com', 'fb.com', 'fb.me'],
        ],

        'instagram' => [
            'label' => 'Instagram',
            'icon' => 'fab fa-instagram',
            'brand' => '#E4405F',
            'placeholder' => 'https://www.instagram.com/yourname',
            'host' => ['instagram.com', 'instagr.am'],
        ],

        'linkedin' => [
            'label' => 'LinkedIn',
            'icon' => 'fab fa-linkedin',
            'brand' => '#0A66C2',
            'placeholder' => 'https://www.linkedin.com/in/yourname',
            'host' => ['linkedin.com', 'lnkd.in'],
        ],

        'twitter' => [
            'label' => 'X (Twitter)',
            'icon' => 'fab fa-twitter',
            'svg' => 'x',
            'brand' => '#111111',
            'placeholder' => 'https://x.com/yourname',
            'host' => ['x.com', 'twitter.com'],
        ],

        'youtube' => [
            'label' => 'YouTube',
            'icon' => 'fab fa-youtube',
            'brand' => '#FF0000',
            'placeholder' => 'https://www.youtube.com/@yourname',
            'host' => ['youtube.com', 'youtu.be'],
        ],

        'tiktok' => [
            'label' => 'TikTok',
            'icon' => 'fab fa-music',
            'svg' => 'tiktok',
            'brand' => '#010101',
            'placeholder' => 'https://www.tiktok.com/@yourname',
            'host' => ['tiktok.com'],
        ],

        'github' => [
            'label' => 'GitHub',
            'icon' => 'fab fa-github',
            'brand' => '#181717',
            'placeholder' => 'https://github.com/yourname',
            'host' => ['github.com'],
        ],

        'xiaohongshu' => [
            'label' => 'Xiaohongshu (小红书)',
            'icon' => 'fas fa-book',
            'svg' => 'xiaohongshu',
            'brand' => '#FF2442',
            'placeholder' => 'https://www.xiaohongshu.com/user/profile/…',
            'host' => ['xiaohongshu.com', 'xhslink.com'],
        ],

        'whatsapp' => [
            'label' => 'WhatsApp',
            'icon' => 'fab fa-whatsapp',
            'brand' => '#25D366',
            'placeholder' => 'https://wa.me/60123456789',
            'host' => ['wa.me', 'whatsapp.com'],
        ],

    ],

];
