<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {

    // --- Dashboard routes group ---
    Route::prefix('/')->group(function () {
        $dashboardNamespace = '\App\Http\Controllers\admin\Dashboard\\';

        Route::get('/', $dashboardNamespace . 'DashboardController@index')->name('dashboard.view');

    });

    // --- Profile routes group ---
    Route::prefix('/profile')->group(function () {
        $profileNamespace = '\App\Http\Controllers\admin\Profile\\';

        Route::get('/', $profileNamespace . 'ProfileController@index')->name('profile.view');

    });

});
