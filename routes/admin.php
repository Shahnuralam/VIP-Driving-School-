<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\InfoCardController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GiftVoucherController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SuburbController;
use App\Http\Controllers\Admin\TheoryCategoryController;
use App\Http\Controllers\Admin\TheoryQuestionController;
use App\Http\Controllers\Admin\WaitlistController;
use App\Http\Controllers\Admin\RescheduleRequestController;
use App\Http\Controllers\Admin\CancellationRequestController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AnalyticsController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Service Categories
    Route::resource('service-categories', ServiceCategoryController::class);

    // Services
    Route::resource('services', ServiceController::class);

    // Packages
    Route::resource('packages', PackageController::class);

    // Locations
    Route::resource('locations', LocationController::class);

    // Bookings
    Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('bookings/calendar/events', [BookingController::class, 'calendarEvents'])->name('bookings.calendar.events');
    Route::get('bookings/pending', [BookingController::class, 'pending'])->name('bookings.pending');
    Route::get('bookings/export', [BookingController::class, 'export'])->name('bookings.export');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::resource('bookings', BookingController::class)->only(['index', 'show', 'destroy']);

    // Availability
    Route::get('availability/calendar/events', [AvailabilityController::class, 'calendarEvents'])->name('availability.calendar.events');
    Route::get('availability/bulk-create', [AvailabilityController::class, 'bulkCreate'])->name('availability.bulk-create');
    Route::post('availability/bulk-store', [AvailabilityController::class, 'bulkStore'])->name('availability.bulk-store');
    Route::delete('availability/bulk-destroy', [AvailabilityController::class, 'bulkDestroy'])->name('availability.bulk-destroy');
    Route::get('availability/blocked', [AvailabilityController::class, 'blocked'])->name('availability.blocked');
    Route::post('availability/block-date', [AvailabilityController::class, 'blockDate'])->name('availability.block-date');
    Route::patch('availability/{availabilitySlot}/toggle-block', [AvailabilityController::class, 'toggleBlock'])->name('availability.toggle-block');
    Route::resource('availability', AvailabilityController::class)->parameters([
        'availability' => 'availabilitySlot'
    ]);

    // Pages
    Route::resource('pages', PageController::class);

    // Info Cards
    Route::resource('info-cards', InfoCardController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);

    // FAQs
    Route::resource('faqs', FaqController::class);

    // Documents
    Route::resource('documents', DocumentController::class);

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/stripe', [SettingController::class, 'stripe'])->name('settings.stripe');
    Route::post('settings/stripe', [SettingController::class, 'updateStripe'])->name('settings.stripe.update');

    // Users
    Route::resource('users', UserController::class);

    // Customers
    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'edit', 'update']);

    // Gift Vouchers
    Route::get('gift-vouchers/{giftVoucher}/send-email', [GiftVoucherController::class, 'sendEmail'])->name('gift-vouchers.send-email');
    Route::resource('gift-vouchers', GiftVoucherController::class);

    // Instructors
    Route::get('instructors/{instructor}/availability', [InstructorController::class, 'availability'])->name('instructors.availability');
    Route::post('instructors/{instructor}/unavailability', [InstructorController::class, 'storeUnavailability'])->name('instructors.unavailability.store');
    Route::delete('instructors/{instructor}/unavailability/{unavailability}', [InstructorController::class, 'destroyUnavailability'])->name('instructors.unavailability.destroy');
    Route::resource('instructors', InstructorController::class);

    // Coupons
    Route::resource('coupons', CouponController::class);

    // Reviews (moderation)
    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond');
    Route::post('reviews/{review}/toggle-featured', [ReviewController::class, 'toggleFeatured'])->name('reviews.toggle-featured');
    Route::post('reviews/{review}/toggle-homepage', [ReviewController::class, 'toggleHomepage'])->name('reviews.toggle-homepage');
    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy']);

    // Blog
    Route::resource('blog/categories', BlogCategoryController::class)->names('blog.categories')->parameters(['categories' => 'blogCategory']);
    Route::resource('blog/posts', BlogPostController::class)->names('blog.posts')->parameters(['posts' => 'post']);

    // Newsletter
    Route::get('newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Suburbs / Service Areas
    Route::resource('suburbs', SuburbController::class);

    // Theory Test
    Route::resource('theory/categories', TheoryCategoryController::class)->names('theory.categories')->parameters(['categories' => 'theoryCategory']);
    Route::resource('theory/categories.questions', TheoryQuestionController::class)->names('theory.questions')->parameters(['category' => 'theoryCategory'])->shallow();

    // Waitlist
    Route::resource('waitlist', WaitlistController::class)->only(['index', 'show', 'update', 'destroy']);

    // Reschedule Requests
    Route::get('reschedule-requests', [RescheduleRequestController::class, 'index'])->name('reschedule-requests.index');
    Route::get('reschedule-requests/{rescheduleRequest}', [RescheduleRequestController::class, 'show'])->name('reschedule-requests.show');
    Route::post('reschedule-requests/{rescheduleRequest}/approve', [RescheduleRequestController::class, 'approve'])->name('reschedule-requests.approve');
    Route::post('reschedule-requests/{rescheduleRequest}/reject', [RescheduleRequestController::class, 'reject'])->name('reschedule-requests.reject');

    // Cancellation / Refund Requests
    Route::get('cancellation-requests', [CancellationRequestController::class, 'index'])->name('cancellation-requests.index');
    Route::get('cancellation-requests/{cancellationRequest}', [CancellationRequestController::class, 'show'])->name('cancellation-requests.show');
    Route::post('cancellation-requests/{cancellationRequest}/process', [CancellationRequestController::class, 'process'])->name('cancellation-requests.process');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});
