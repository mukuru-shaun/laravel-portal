<?php

use App\Http\Controllers\AccessRequestController;
use App\Http\Controllers\ExternalAccountController;
use App\Http\Controllers\UserController;
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
    Route::view('/', 'dashboard')->name('dashboard');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'saveProfile'])->name('save-profile');

    Route::get('/external-accounts', [ExternalAccountController::class, 'accountsList'])->name('external-accounts');
    Route::get('/external-accounts/redirect/{provider}', [ExternalAccountController::class, 'redirect'])->name('external-accounts-redirect');
    Route::get('/external-accounts/callback/{provider}', [ExternalAccountController::class, 'callback'])->name('external-accounts-callback');

    Route::get('/access-request', [AccessRequestController::class, 'accessRequest'])->name('access-request');
    Route::post('/access-request', [AccessRequestController::class, 'saveAccessRequest'])->name('save-access-request');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('azure')
        ->setScopes(['User.Read.All'])
        ->redirect();
})->name('auth');

Route::get('/auth/callback', function () { //TODO, move this to a controller using a service for user creation
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

    // Instead of storing the token in the db for now we will just keep it in the session
    session(['azureToken' => $user->token]);
    Auth::login($authUser);

    return redirect('/');
});

