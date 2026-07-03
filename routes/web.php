<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\BridalPackageController as AdminBridalPackageController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\ContactSettingController as AdminContactSettingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryImageController as AdminGalleryImageController;
use App\Http\Controllers\Admin\NavMenuItemController as AdminNavMenuItemController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\BridalPackageController;
use App\Http\Controllers\ContactSettingController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Models\BridalPackage;
use App\Models\ContactSetting;
use App\Models\HeroSlide;
use App\Models\GalleryImage;
use App\Models\NavMenuItem;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $navItems = NavMenuItem::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    if ($navItems->isEmpty()) {
        $navItems = collect([
            (object) ['label' => 'Gallery', 'href' => route('gallery'), 'open_in_new_tab' => false],
            (object) ['label' => 'Testimonials', 'href' => '#testimonials', 'open_in_new_tab' => false],
            (object) ['label' => 'Contact', 'href' => '#contact', 'open_in_new_tab' => false],
        ]);
    }

    return view('frontend.home', [
        'navItems' => $navItems,
        'heroSlides' => HeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(),
        'services' => Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(),
        'bridalPackages' => BridalPackage::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get(),
        'galleryImages' => GalleryImage::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get(),
        'testimonials' => Testimonial::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get(),
        'contactSetting' => ContactSetting::query()
            ->where('is_active', true)
            ->latest()
            ->first(),
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('auth.password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('auth.password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('auth.password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/appointments', [AuthController::class, 'dashboardAppointments'])->name('dashboard.appointments');
    Route::get('/dashboard/appointments/{appointment}', [AuthController::class, 'dashboardAppointmentShow'])->name('dashboard.appointments.show');
    Route::get('/dashboard/settings', [AuthController::class, 'dashboardSettings'])->name('dashboard.settings');
    Route::put('/dashboard/settings', [AuthController::class, 'updateDashboardSettings'])->name('dashboard.settings.update');
    Route::put('/dashboard/settings/password', [AuthController::class, 'updateDashboardPassword'])->name('dashboard.settings.password');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::resource('bridal-packages', BridalPackageController::class)->only(['index', 'show']);
Route::get('/packages/{slug}', [BridalPackageController::class, 'detail'])->name('packages.show');
Route::get('/packages/{slug}/book', [BridalPackageController::class, 'book'])->middleware('auth')->name('packages.book');
Route::resource('gallery-images', GalleryImageController::class)->only(['index', 'show']);
Route::get('/gallery', [GalleryImageController::class, 'gallery'])->name('gallery');
Route::resource('testimonials', TestimonialController::class)->only(['index', 'show']);
Route::resource('appointments', AppointmentController::class)->only(['index', 'store', 'show']);
Route::resource('contact-settings', ContactSettingController::class)->only(['index', 'show']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'login'])->name('login');
        Route::post('login', [AdminAuthController::class, 'authenticate'])->name('login.store');
        Route::get('register', [AdminAuthController::class, 'register'])->name('register');
        Route::post('register', [AdminAuthController::class, 'store'])->name('register.store');
    });

    Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('admin.auth')->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('services', AdminServiceController::class);
        Route::resource('bridal-packages', AdminBridalPackageController::class);
        Route::resource('gallery-images', AdminGalleryImageController::class);
        Route::resource('nav-menu-items', AdminNavMenuItemController::class);
        Route::resource('testimonials', AdminTestimonialController::class);
        Route::resource('hero-slides', AdminHeroSlideController::class);
        Route::resource('users', AdminUserController::class)->only(['index', 'show']);
        Route::resource('bookings', AdminBookingController::class)->only(['index', 'show']);
        Route::resource('appointments', AdminAppointmentController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::get('contact-settings', [AdminContactSettingController::class, 'edit'])->name('contact-settings.edit');
        Route::put('contact-settings', [AdminContactSettingController::class, 'update'])->name('contact-settings.update');
        Route::get('profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::post('password', [AdminAuthController::class, 'updatePassword'])->name('password.update');
    });
});
