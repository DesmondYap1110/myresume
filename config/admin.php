<?php

/*
|--------------------------------------------------------------------------
| First administrator
|--------------------------------------------------------------------------
|
| On a brand new database, "php artisan migrate" creates this account so the
| back office can be reached straight after deploying. Nothing needs setting
| in .env first - the values live here, and the migration that creates the
| account carries its own copy so it works even without a config cache.
|
| Keep these in step with the constants at the top of
| database/migrations/2026_09_18_000002_create_first_admin_user.php.
|
| The password is public knowledge (it is in this repository), so the admin
| is sent to Account Setting to change it until they do.
|
*/

return [

    'email' => 'desmondyap1110@gmail.com',
    'password' => '123456',
    'name' => 'Yap Jia Chun',
    'slug' => 'desmond-yap',
    'template' => 'template1',

];
