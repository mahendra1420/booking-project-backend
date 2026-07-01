<?php

use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BusinessController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\Business\BusinessController as BusinessOwnerController;
use App\Http\Controllers\Business\ServiceController as BusinessServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ── Public Routes (no auth required) ────────────────────────────────────────

Route::prefix('v1')->group(function () {

    // Auth
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login',    [AuthController::class, 'login'])->name('auth.login');

    // Public Business Listing
    Route::get('/business',      [BusinessController::class, 'index'])->name('business.index');
    Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');

    // Business Register (no login required)
    Route::post('/business/register', [BusinessOwnerController::class, 'register'])->name('business.register');

    // Public Service Listing
    Route::get('/services/{business}', [ServiceController::class, 'index'])->name('services.index');

    // Public Reviews
    Route::get('/reviews/{business}', [ReviewController::class, 'index'])->name('reviews.index');

    // ── Authenticated Routes ─────────────────────────────────────────────────

    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/me',      [AuthController::class, 'me'])->name('auth.me');

        // Appointments (Customer)
        Route::get('/appointments',          [AppointmentController::class, 'index'])->name('appointments.index');
        Route::post('/appointment',          [AppointmentController::class, 'store'])->name('appointments.store');
        Route::put('/appointment/{id}',      [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointment/{id}',   [AppointmentController::class, 'destroy'])->name('appointments.destroy');

        // Reviews (Customer)
        Route::post('/review', [ReviewController::class, 'store'])->name('reviews.store');

        // ── Business Owner Routes ────────────────────────────────────────────

        Route::prefix('business')->name('business.')->group(function () {
            Route::get('/my',        [BusinessOwnerController::class, 'myBusinesses'])->name('my');
        });

        // Service Management (Business Owner)
        Route::prefix('service')->name('service.')->group(function () {
            Route::post('/',        [BusinessServiceController::class, 'store'])->name('store');
            Route::put('/{id}',     [BusinessServiceController::class, 'update'])->name('update');
            Route::delete('/{id}',  [BusinessServiceController::class, 'destroy'])->name('destroy');
        });
    });
});
