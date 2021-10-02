<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Integrations\TwilioCallController;
use App\Http\Controllers\Integrations\TwilioSmsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamPhoneNumberController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->prefix('teams')->group(function() {
    Route::get('create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::put('/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::post('/phone-numbers', [TeamPhoneNumberController::class, 'store'])->name('phone-numbers.store');
    Route::put('/phone-numbers/{id}', [TeamPhoneNumberController::class, 'update'])->name('phone-numbers.update');
});

Route::group(['prefix' => 'integrations'], function() {
    Route::prefix('twilio')->name('twilio.')->group(function() {
        Route::resource('call', TwilioCallController::class)->except(['index', 'show', 'destroy']);
        Route::resource('sms', TwilioSmsController::class)->except(['index', 'show', 'destroy']);
    });
});
