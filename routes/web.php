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
    Route::get('/', function () {
        $user = Auth::user();
        dd($user);
    });
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
        ]);
    }

    Auth::login($authUser);
    return redirect('/');
});

