<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\AccessRequestController;
use App\Http\Controllers\ExternalAccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function() {
    Route::view('/', 'dashboard')->name('dashboard');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'saveProfile'])->name('save-profile');

    Route::get('/external-accounts', [ExternalAccountController::class, 'accountsList'])->name('external-accounts');
    Route::get('/external-accounts/redirect/{provider}', [ExternalAccountController::class, 'redirect'])->name('external-accounts-redirect');
    Route::get('/external-accounts/callback/{provider}', [ExternalAccountController::class, 'callback'])->name('external-accounts-callback');

    Route::get('/access-request', [AccessRequestController::class, 'accessRequest'])->name('access-request');
    Route::post('/access-request', [AccessRequestController::class, 'saveAccessRequest'])->name('save-access-request');
});

Route::get('/auth/redirect', [OAuthController::class, 'redirectToProvider'])->name('auth');
Route::get('/auth/callback', [OAuthController::class, 'providerCallback'])->name('auth-callback');

