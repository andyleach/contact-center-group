<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\TwilioPhoneNumberSearchController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ClientPhoneNumberController;
use App\Http\Controllers\Integrations\TwilioInboundCallController;
use App\Http\Controllers\Integrations\TwilioInboundSmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::resource('clients', ClientController::class);
    Route::resource('client-phone-numbers', ClientPhoneNumberController::class);
    Route::group(['prefix' => 'twilio'], function() {
        Route::get('search-local-phone-numbers', [TwilioPhoneNumberSearchController::class, 'searchLocalPhoneNumbers'])
            ->name('twilio.search-local-numbers');
    });
});

Route::group(['prefix' => 'integrations'], function() {
    Route::group(['prefix' => 'twilio'], function() {
        Route::post('call/inbound', [TwilioInboundCallController::class, 'store'])->name('twilio.call.inbound');
        Route::post('sms/inbound', [TwilioInboundSmsController::class, 'store'])->name('twilio.sms.inbound');
    });

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
