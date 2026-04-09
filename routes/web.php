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

    // --- Login routes group ---
    Route::prefix('/')->group(function () {
        $loginNamespace = '\App\Http\Controllers\admin\Auth\\';

        Route::get('/', $loginNamespace . 'AuthController@index')->name('login.view');

    });

    // --- Dashboard routes group ---
    Route::prefix('/dashboard')->group(function () {
        $dashboardNamespace = '\App\Http\Controllers\admin\Dashboard\\';

        Route::get('/', $dashboardNamespace . 'DashboardController@index')->name('dashboard.view');

    });

    // --- Profile routes group ---
    Route::prefix('/profile')->group(function () {
        $profileNamespace = '\App\Http\Controllers\admin\Profile\\';

        Route::get('/', $profileNamespace . 'ProfileController@index')->name('profile.view');

    });

    // --- Profile routes group ---
    Route::prefix('/setting')->group(function () {
        $settingNamespace = '\App\Http\Controllers\admin\Setting\\';

        Route::get('/', $settingNamespace . 'SettingController@index')->name('setting.view');

    });

    // --- Education routes group ---
    Route::prefix('/education')->group(function () {
        $educationNamespace = '\App\Http\Controllers\admin\Education\\';

        Route::get('/', $educationNamespace . 'EducationController@index')->name('education.view');

    });

    // --- Experience routes group ---
    Route::prefix('/experience')->group(function () {
        $experienceNamespace = '\App\Http\Controllers\admin\Experience\\';

        Route::get('/', $experienceNamespace . 'ExperienceController@index')->name('experience.view');

    });

    // --- Project routes group ---
    Route::prefix('/project')->group(function () {
        $projectNamespace = '\App\Http\Controllers\admin\Project\\';

        Route::get('/', $projectNamespace . 'ProjectController@index')->name('project.view');

    });

    // --- Blog routes group ---
    Route::prefix('/blog')->group(function () {
        $blogNamespace = '\App\Http\Controllers\admin\Blog\\';

        Route::get('/', $blogNamespace . 'BlogController@index')->name('blog.view');

    });


    // --- Inbox routes group ---
    Route::prefix('/inbox')->group(function () {
        $inboxNamespace = '\App\Http\Controllers\admin\Inbox\\';

        Route::get('/', $inboxNamespace . 'InboxController@index')->name('inbox.view');

    });



});
