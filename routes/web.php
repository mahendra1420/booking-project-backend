<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('admin.login'));

// ── Admin Auth ─────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',  [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.post')->middleware('throttle:10,1');
    Route::post('/logout',[Admin\AuthController::class, 'logout'])->name('logout');

    // ── Protected Admin Routes ─────────────────────────────────────────────────
    Route::middleware(\App\Http\Middleware\AdminAuthenticate::class)->group(function () {

        // Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Customers
        Route::resource('customers', Admin\CustomerController::class)->only(['index', 'show', 'destroy']);
        Route::post('customers/{id}/toggle-block', [Admin\CustomerController::class, 'toggleBlock'])->name('customers.toggle-block');
        Route::get('customers-export',             [Admin\CustomerController::class, 'export'])->name('customers.export');

        // Businesses
        Route::get('businesses',               [Admin\BusinessController::class, 'index'])->name('businesses.index');
        Route::get('businesses/{business}',    [Admin\BusinessController::class, 'show'])->name('businesses.show');
        Route::get('businesses/{business}/edit',[Admin\BusinessController::class, 'edit'])->name('businesses.edit');
        Route::put('businesses/{business}',    [Admin\BusinessController::class, 'update'])->name('businesses.update');
        Route::delete('businesses/{business}', [Admin\BusinessController::class, 'destroy'])->name('businesses.destroy');
        Route::post('businesses/{id}/approve', [Admin\BusinessController::class, 'approve'])->name('businesses.approve');
        Route::post('businesses/{id}/reject',  [Admin\BusinessController::class, 'reject'])->name('businesses.reject');
        Route::post('businesses/{id}/suspend', [Admin\BusinessController::class, 'suspend'])->name('businesses.suspend');
        Route::post('businesses/{id}/feature', [Admin\BusinessController::class, 'feature'])->name('businesses.feature');

        // Categories
        Route::resource('categories', Admin\CategoryController::class);
        Route::post('categories/reorder', [Admin\CategoryController::class, 'reorder'])->name('categories.reorder');

        // Appointments
        Route::get('appointments',             [Admin\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{id}',        [Admin\AppointmentController::class, 'show'])->name('appointments.show');
        Route::post('appointments/{id}/status',[Admin\AppointmentController::class, 'updateStatus'])->name('appointments.status');

        // Payments
        Route::get('payments',                 [Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{id}',            [Admin\PaymentController::class, 'show'])->name('payments.show');
        Route::post('payments/{id}/refund',    [Admin\PaymentController::class, 'refund'])->name('payments.refund');

        // Payouts
        Route::get('payouts',                  [Admin\PayoutController::class, 'index'])->name('payouts.index');
        Route::post('payouts/{id}/process',    [Admin\PayoutController::class, 'process'])->name('payouts.process');

        // Coupons
        Route::resource('coupons', Admin\CouponController::class);

        // Banners
        Route::resource('banners', Admin\BannerController::class);

        // Notifications
        Route::get('notifications',            [Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/send',      [Admin\NotificationController::class, 'send'])->name('notifications.send');

        // Reviews
        Route::get('reviews',                  [Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews/{id}/hide',       [Admin\ReviewController::class, 'hide'])->name('reviews.hide');
        Route::delete('reviews/{id}',          [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('revenue',              [Admin\ReportController::class, 'revenue'])->name('revenue');
            Route::get('bookings',             [Admin\ReportController::class, 'bookings'])->name('bookings');
            Route::get('customers',            [Admin\ReportController::class, 'customers'])->name('customers');
            Route::get('commission',           [Admin\ReportController::class, 'commission'])->name('commission');
            Route::get('export/{type}',        [Admin\ReportController::class, 'export'])->name('export');
        });

        // CMS
        Route::resource('cms', Admin\CmsController::class);

        // Settings
        Route::get('settings',                 [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings',                [Admin\SettingController::class, 'update'])->name('settings.update');

        // Roles & Permissions
        Route::resource('roles', Admin\RoleController::class);
        Route::post('roles/{id}/permissions',  [Admin\RoleController::class, 'updatePermissions'])->name('roles.permissions');

        // Support
        Route::resource('support', Admin\SupportController::class)->only(['index', 'show', 'destroy']);
        Route::post('support/{id}/reply',      [Admin\SupportController::class, 'reply'])->name('support.reply');
        Route::post('support/{id}/assign',     [Admin\SupportController::class, 'assign'])->name('support.assign');
        Route::post('support/{id}/close',      [Admin\SupportController::class, 'close'])->name('support.close');

        // Audit Logs
        Route::get('audit-logs',               [Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
    });
});
