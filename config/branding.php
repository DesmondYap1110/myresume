<?php

/*
|--------------------------------------------------------------------------
| Branding
|--------------------------------------------------------------------------
|
| Admin colour presets and the login background. Colours are emitted as
| --brand-* CSS custom properties by <x-template1.admin.master.branding-styles />
| and applied over KaiAdmin. What an admin saves under Theme Setting
| (theme_setting table) layers on top of these values.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Login background
    |--------------------------------------------------------------------------
    |
    | Set 'image' to an empty string to drop the image and fall back to the
    | flat 'colour'.
    |
    */

    'background' => [
        'image' => env('APP_BACKGROUND_IMAGE', 'assets/admin/img/bg/bg-3.jpg'),
        'colour' => env('APP_BACKGROUND_COLOR', '#000000'),
        'size' => 'cover',
        'position' => 'center',
        'repeat' => 'no-repeat',
        'attachment' => 'fixed',
        'overlay' => env('APP_BACKGROUND_OVERLAY', 'rgba(0, 0, 0, 0.35)'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | 'theme' is the preset used until an admin picks one (and after reset).
    |
    */

    'theme' => 'default',

    'presets' => [

        // The shipped black & gold look.
        'default' => [
            'primary' => '#212529',
            'primary-hover' => '#000000',
            'button-text' => '#FFD700',
            'accent' => '#FFD700',
            'sidebar' => '#1A2035',
            'logo-header' => '#000000',
            'background' => '#F5F7FD',
            'link' => '#1572E8',
        ],

        'ocean-blue' => [
            'primary' => '#1572E8',
            'primary-hover' => '#1259B8',
            'button-text' => '#FFFFFF',
            'accent' => '#FFFFFF',
            'sidebar' => '#1A2035',
            'logo-header' => '#1572E8',
            'background' => '#F5F7FD',
            'link' => '#1572E8',
        ],

        'indigo' => [
            'primary' => '#6366F1',
            'primary-hover' => '#4F46E5',
            'button-text' => '#FFFFFF',
            'accent' => '#C7D2FE',
            'sidebar' => '#1E1B4B',
            'logo-header' => '#312E81',
            'background' => '#F8FAFC',
            'link' => '#6366F1',
        ],

        'light-green' => [
            'primary' => '#22A65E',
            'primary-hover' => '#1B8A4E',
            'button-text' => '#FFFFFF',
            'accent' => '#A3E635',
            'sidebar' => '#14532D',
            'logo-header' => '#0F3D21',
            'background' => '#F2FBF5',
            'link' => '#16A34A',
        ],

        'slate' => [
            'primary' => '#0EA5E9',
            'primary-hover' => '#0284C7',
            'button-text' => '#FFFFFF',
            'accent' => '#38BDF8',
            'sidebar' => '#0F172A',
            'logo-header' => '#020617',
            'background' => '#F1F5F9',
            'link' => '#0EA5E9',
        ],

        'rose' => [
            'primary' => '#E11D48',
            'primary-hover' => '#BE123C',
            'button-text' => '#FFFFFF',
            'accent' => '#FDA4AF',
            'sidebar' => '#2A0A12',
            'logo-header' => '#1A050B',
            'background' => '#FFF5F7',
            'link' => '#E11D48',
        ],

    ],

];
