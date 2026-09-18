<?php

/*
|--------------------------------------------------------------------------
| First administrator
|--------------------------------------------------------------------------
|
| On a brand new database, "php artisan migrate" creates this account so the
| back office can be reached straight after deploying. Set ADMIN_EMAIL and
| ADMIN_PASSWORD in .env BEFORE the first migrate to use your own.
|
| The default password is public knowledge (it is in this repository), so the
| admin is sent to Account Setting to change it until they do.
|
*/

return [

    'email' => env('ADMIN_EMAIL', 'desmondyap@gmail.com'),
    'password' => env('ADMIN_PASSWORD', '123456'),
    'name' => env('ADMIN_NAME', 'Yap Jia Chun'),
    'slug' => env('ADMIN_SLUG', 'desmond-yap'),
    'template' => env('ADMIN_TEMPLATE', 'template1'),

];
