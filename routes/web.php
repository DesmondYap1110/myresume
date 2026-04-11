<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Education\EducationController;
use App\Http\Controllers\Admin\Experience\ExperienceController;
use App\Http\Controllers\Admin\Project\ProjectController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Inbox\InboxController;

Route::prefix('admin')->group(function () {

    // ---------------- LOGIN ----------------
    Route::get('/', [AuthController::class, 'index'])->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // ---------------- PROTECTED AREA ----------------
    Route::middleware('auth')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('login.logout');

        // ---------------- DASHBOARD ----------------
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard.view');
        });

        // ---------------- PROFILE ----------------
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profile.view');
            Route::get('/add', [ProfileController::class, 'add'])->name('profile.add');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/delete', [ProfileController::class, 'delete'])->name('profile.delete');
            Route::post('/create', [ProfileController::class, 'create'])->name('profile.create');
            Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        });

        // ---------------- SETTING ----------------
        Route::prefix('setting')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting.view');
            Route::post('/update', [SettingController::class, 'update'])->name('setting.update');
        });

        // ---------------- EDUCATION ----------------
        Route::prefix('education')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('education.view');
            Route::get('/add', [EducationController::class, 'add'])->name('education.add');
            Route::get('/edit', [EducationController::class, 'edit'])->name('education.edit');
            Route::post('/delete', [EducationController::class, 'delete'])->name('education.delete');
            Route::post('/create', [EducationController::class, 'create'])->name('education.create');
            Route::post('/update', [EducationController::class, 'update'])->name('education.update');
        });

        // ---------------- EXPERIENCE ----------------
        Route::prefix('experience')->group(function () {
            Route::get('/', [ExperienceController::class, 'index'])->name('experience.view');
            Route::get('/add', [ExperienceController::class, 'add'])->name('experience.add');
            Route::get('/edit', [ExperienceController::class, 'edit'])->name('experience.edit');
            Route::post('/delete', [ExperienceController::class, 'delete'])->name('experience.delete');
            Route::post('/create', [ExperienceController::class, 'create'])->name('experience.create');
            Route::post('/update', [ExperienceController::class, 'update'])->name('experience.update');
        });

        // ---------------- PROJECT ----------------
        Route::prefix('project')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('project.view');
            Route::get('/add', [ProjectController::class, 'add'])->name('project.add');
            Route::get('/edit', [ProjectController::class, 'edit'])->name('project.edit');
            Route::post('/delete', [ProjectController::class, 'delete'])->name('project.delete');
            Route::post('/create', [ProjectController::class, 'create'])->name('project.create');
            Route::post('/update', [ProjectController::class, 'update'])->name('project.update');
        });

        // ---------------- BLOG ----------------
        Route::prefix('blog')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog.view');
            Route::get('/add', [BlogController::class, 'add'])->name('blog.add');
            Route::get('/edit', [BlogController::class, 'edit'])->name('blog.edit');
            Route::post('/delete', [BlogController::class, 'delete'])->name('blog.delete');
            Route::post('/create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('/update', [BlogController::class, 'update'])->name('blog.update');
        });

        // ---------------- INBOX ----------------
        Route::prefix('inbox')->group(function () {
            Route::get('/', [InboxController::class, 'index'])->name('inbox.view');
            Route::get('/{id}', [InboxController::class, 'viewmessage'])->name('inbox.view.message');
            Route::post('/delete', [InboxController::class, 'delete'])->name('inbox.delete');
        });

    });

});
