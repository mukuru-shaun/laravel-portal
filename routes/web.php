<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
    Route::view('/', 'dashboard');

    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\UserController::class, 'saveProfile'])->name('save-profile');

    Route::get('/external-accounts', [\App\Http\Controllers\ExternalAccountController::class, 'accountsList'])->name('external-accounts');
    Route::get('/external-accounts/redirect/{provider}', [\App\Http\Controllers\ExternalAccountController::class, 'redirect'])->name('external-accounts-redirect');
    Route::get('/external-accounts/callback/{provider}', [\App\Http\Controllers\ExternalAccountController::class, 'callback'])->name('external-accounts-callback');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('azure')->redirect();
})->name('auth');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('azure')->user();

    $authUser = User::where('email', '=', $user->getEmail())->first();

    if (! $authUser) {
        $authUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'provider' => 'azure',
            'provider_id' => $user->getId(),
        ]);
    }

    Auth::login($authUser);
    return redirect('/');
});

