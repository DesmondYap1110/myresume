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
        Route::get('/logout', $loginNamespace . 'AuthController@index')->name('logout.view');

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
        Route::get('/add', $profileNamespace . 'ProfileController@add')->name('profile.add');
        Route::get('/edit', $profileNamespace . 'ProfileController@edit')->name('profile.edit');
        Route::post('/delete', $profileNamespace . 'ProfileController@delete')->name('profile.delete');
        Route::post('/create', $profileNamespace . 'ProfileController@create')->name('profile.create');
        Route::post('/update', $profileNamespace . 'ProfileController@update')->name('profile.update');

    });

    // --- Profile routes group ---
    Route::prefix('/setting')->group(function () {
        $settingNamespace = '\App\Http\Controllers\admin\Setting\\';

        Route::get('/', $settingNamespace . 'SettingController@index')->name('setting.view');
        Route::post('/update', $settingNamespace . 'SettingController@update')->name('setting.update');

    });

    // --- Education routes group ---
    Route::prefix('/education')->group(function () {
        $educationNamespace = '\App\Http\Controllers\admin\Education\\';

        Route::get('/', $educationNamespace . 'EducationController@index')->name('education.view');
        Route::get('/add', $educationNamespace . 'EducationController@add')->name('education.add');
        Route::get('/edit', $educationNamespace . 'EducationController@edit')->name('education.edit');
        Route::post('/delete', $educationNamespace . 'EducationController@delete')->name('education.delete');
        Route::post('/create', $educationNamespace . 'EducationController@create')->name('education.create');
        Route::post('/update', $educationNamespace . 'EducationController@update')->name('education.update');

    });

    // --- Experience routes group ---
    Route::prefix('/experience')->group(function () {

        $experienceNamespace = '\App\Http\Controllers\admin\Experience\\';
        Route::get('/', $experienceNamespace . 'ExperienceController@index')->name('experience.view');
        Route::get('/add', $experienceNamespace . 'ExperienceController@add')->name('experience.add');
        Route::get('/edit', $experienceNamespace . 'ExperienceController@edit')->name('experience.edit');
        Route::post('/delete', $experienceNamespace . 'ExperienceController@delete')->name('experience.delete');
        Route::post('/create', $experienceNamespace . 'ExperienceController@create')->name('experience.create');
        Route::post('/update', $experienceNamespace . 'ExperienceController@update')->name('experience.update');

    });

    // --- Project routes group ---
    Route::prefix('/project')->group(function () {
        $projectNamespace = '\App\Http\Controllers\admin\Project\\';

        Route::get('/', $projectNamespace . 'ProjectController@index')->name('project.view');
        Route::get('/add', $projectNamespace . 'ProjectController@add')->name('project.add');
        Route::get('/edit', $projectNamespace . 'ProjectController@edit')->name('project.edit');
        Route::post('/delete', $projectNamespace . 'ProjectController@delete')->name('project.delete');
        Route::post('/create', $projectNamespace . 'ProjectController@create')->name('project.create');
        Route::post('/update', $projectNamespace . 'ProjectController@update')->name('project.update');

    });

    // --- Blog routes group ---
    Route::prefix('/blog')->group(function () {
        $blogNamespace = '\App\Http\Controllers\admin\Blog\\';

        Route::get('/', $blogNamespace . 'BlogController@index')->name('blog.view');
        Route::get('/add', $blogNamespace . 'BlogController@add')->name('blog.add');
        Route::get('/edit', $blogNamespace . 'BlogController@edit')->name('blog.edit');
        Route::post('/delete', $blogNamespace . 'BlogController@delete')->name('blog.delete');
        Route::post('/create', $blogNamespace . 'BlogController@create')->name('blog.create');
        Route::post('/update', $blogNamespace . 'BlogController@update')->name('blog.update');

    });


    // --- Inbox routes group ---
    Route::prefix('/inbox')->group(function () {
        $inboxNamespace = '\App\Http\Controllers\admin\Inbox\\';

        Route::get('/', $inboxNamespace . 'InboxController@index')->name('inbox.view');
        Route::get('/{id}', $inboxNamespace . 'InboxController@viewmessage')->name('inbox.view.message');
        Route::post('/delete', $inboxNamespace . 'InboxController@delete')->name('inbox.delete');

    });



});
