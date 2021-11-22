<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Socialite;

class OAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('azure')
            ->setScopes(['User.Read.All'])
            ->redirect();

    }

    public function providerCallback()
    {
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

        return redirect()->route('dashboard');
    }
}
