<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Theme\ThemeController;
use App\Http\Controllers\Admin\Education\EducationController;
use App\Http\Controllers\Admin\Experience\ExperienceController;
use App\Http\Controllers\Admin\Project\ProjectController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Admin\Testimonial\TestimonialController;
use App\Http\Controllers\Admin\Inbox\InboxController;
use App\Http\Controllers\Website\FrontEndController;
use App\Http\Controllers\Website\SitemapController;

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('{id}', [FrontEndController::class, 'index'])->name('front.show');
// Blog post page; the user id stays last because LogFrontendVisit reads the last segment.
Route::get('post/{blog}/{id}', [FrontEndController::class, 'post'])->whereNumber('blog')->name('front.post');
Route::post('enquiry/{id}', [FrontEndController::class, 'contact'])->name('front.contact');


Route::prefix('admin')->group(function () {

    // ---------------- LOGIN ----------------
    Route::get('/login', [AuthController::class, 'index'])->name('login.index');
    Route::post('/login/submit', [AuthController::class, 'login'])->name('login.submit');

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
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::post('/upload/image', [ProfileController::class, 'upload_img'])->name('profile.upload');
        });

        // ---------------- SETTING ----------------
        Route::prefix('setting')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting.view');
            Route::post('/update', [SettingController::class, 'update'])->name('setting.update');
            Route::post('/template', [SettingController::class, 'template'])->name('setting.template');
        });

        // ---------------- THEME ----------------
        Route::prefix('theme')->group(function () {
            Route::get('/', [ThemeController::class, 'index'])->name('theme.view');
            Route::post('/update', [ThemeController::class, 'update'])->name('theme.update');
            Route::post('/reset', [ThemeController::class, 'reset'])->name('theme.reset');
        });

        // ---------------- EDUCATION ----------------
        Route::prefix('education')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('education.view');
            Route::get('/add', [EducationController::class, 'add'])->name('education.add');
            Route::get('/edit/{id}', [EducationController::class, 'edit'])->name('education.edit');
            Route::get('/delete/{id}', [EducationController::class, 'delete'])->name('education.delete');
            Route::post('/create', [EducationController::class, 'create'])->name('education.create');
            Route::post('/update/{id}', [EducationController::class, 'update'])->name('education.update');
        });

        // ---------------- EXPERIENCE ----------------
        Route::prefix('experience')->group(function () {
            Route::get('/', [ExperienceController::class, 'index'])->name('experience.view');
            Route::get('/add', [ExperienceController::class, 'add'])->name('experience.add');
            Route::get('/edit/{id}', [ExperienceController::class, 'edit'])->name('experience.edit');
            Route::get('/delete/{id}', [ExperienceController::class, 'delete'])->name('experience.delete');
            Route::post('/create', [ExperienceController::class, 'create'])->name('experience.create');
            Route::post('/update/{id}', [ExperienceController::class, 'update'])->name('experience.update');
        });

        // ---------------- PROJECT ----------------
        Route::prefix('project')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('project.view');
            Route::get('/add', [ProjectController::class, 'add'])->name('project.add');
            Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
            Route::get('/delete/{id}', [ProjectController::class, 'delete'])->name('project.delete');
            Route::post('/create', [ProjectController::class, 'create'])->name('project.create');
            Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
        });

        // ---------------- SERVICE ----------------
        Route::prefix('service')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('service.view');
            Route::get('/add', [ServiceController::class, 'add'])->name('service.add');
            Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
            Route::get('/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
            Route::post('/create', [ServiceController::class, 'create'])->name('service.create');
            Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        });

        // ---------------- TESTIMONIAL ----------------
        Route::prefix('testimonial')->group(function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('testimonial.view');
            Route::get('/add', [TestimonialController::class, 'add'])->name('testimonial.add');
            Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
            Route::get('/delete/{id}', [TestimonialController::class, 'delete'])->name('testimonial.delete');
            Route::post('/create', [TestimonialController::class, 'create'])->name('testimonial.create');
            Route::post('/update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
        });

        // ---------------- BLOG ----------------
        Route::prefix('blog')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog.view');
            Route::get('/add', [BlogController::class, 'add'])->name('blog.add');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
            Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');
            Route::post('/create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('/update/{id}', [BlogController::class, 'update'])->name('blog.update');
        });

        // ---------------- INBOX ----------------
        Route::prefix('inbox')->group(function () {
            Route::get('/', [InboxController::class, 'index'])->name('inbox.view');
            Route::get('/{id}', [InboxController::class, 'viewmessage'])->name('inbox.view.message');
            Route::get('/delete/{id}', [InboxController::class, 'delete'])->name('inbox.delete');
            Route::get('/edit/status/{id}', [InboxController::class, 'status'])->name('inbox.status');
            Route::post('/edit/status1/{id}', [InboxController::class, 'editstatus'])->name('inbox.status2');
            Route::get('/edit/status3', [InboxController::class, 'readAll'])->name('inbox.status3');
        });

    });

});
