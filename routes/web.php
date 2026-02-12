<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PackageController;
use App\Http\Controllers\Frontend\AssessmentController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Auth::routes(['register' => false]); // Disable public registration

// Include Admin Routes
require __DIR__.'/admin.php';

// Redirect home to admin dashboard for authenticated users
Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');

// Lesson Packages
Route::get('/lesson-packages', [PackageController::class, 'index'])->name('lesson-packages');

// P1 Assessments
Route::get('/p1-assessments', [AssessmentController::class, 'index'])->name('p1-assessments');

// Book Online
Route::get('/book-online', [BookingController::class, 'index'])->name('book-online');
Route::get('/book-online/slots', [BookingController::class, 'getSlots'])->name('book-online.slots');
Route::post('/book-online', [BookingController::class, 'store'])->name('book-online.store');
Route::get('/booking/confirmation/{reference}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Customer Account Routes
|--------------------------------------------------------------------------
*/

// Customer Auth Routes (Guest)
Route::middleware('customer.guest')->prefix('account')->group(function () {
    Route::get('/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'showRegistrationForm'])->name('customer.register');
    Route::post('/register', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'register']);
    Route::get('/forgot-password', [App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Customer\Auth\ResetPasswordController::class, 'showResetForm'])->name('customer.password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Customer\Auth\ResetPasswordController::class, 'reset'])->name('customer.password.update');
});

// Customer Protected Routes
Route::middleware('customer.auth')->prefix('account')->name('customer.')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Customer\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [App\Http\Controllers\Customer\ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::get('/change-password', [App\Http\Controllers\Customer\ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::put('/change-password', [App\Http\Controllers\Customer\ProfileController::class, 'changePassword'])->name('password.update');
    
    // Bookings
    Route::get('/bookings', [App\Http\Controllers\Customer\BookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Customer\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/reschedule', [App\Http\Controllers\Customer\BookingController::class, 'showRescheduleForm'])->name('bookings.reschedule');
    Route::post('/bookings/{booking}/reschedule', [App\Http\Controllers\Customer\BookingController::class, 'reschedule'])->name('bookings.reschedule.store');
    Route::get('/bookings/{booking}/cancel', [App\Http\Controllers\Customer\BookingController::class, 'showCancelForm'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/cancel', [App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('bookings.cancel.store');
    Route::get('/bookings/{booking}/rebook', [App\Http\Controllers\Customer\BookingController::class, 'rebook'])->name('bookings.rebook');
    
    // Reviews
    Route::get('/reviews', [App\Http\Controllers\Customer\ReviewController::class, 'index'])->name('reviews');
    Route::get('/bookings/{booking}/review', [App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('reviews.store');
});

// Dynamic Pages (must be last to avoid conflicting with other routes)
Route::get('/{slug}', [App\Http\Controllers\Frontend\PageController::class, 'show'])
    ->where('slug', '^(?!admin|login|logout|register|password|home|book-online|booking|api).*$')
    ->name('page.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
