<?php

namespace App\Http\Controllers;

use App\Services\User\UserService;
use Auth;
use Socialite;

class OAuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}
    public function redirectToProvider()
    {
        return Socialite::driver('azure')
            ->setScopes(['User.Read.All'])
            ->redirect();
    }

    public function providerCallback()
    {
        $user = Socialite::driver('azure')->user();

        $authUser = $this->userService->findUserByEmail($user->getEmail())
            ?? $this->userService->createUser($user->getName(), $user->getEmail(), 'azure', $user->getId());

        // Instead of storing the token in the db for now we will just keep it in the session
        session(['azureToken' => $user->token]);
        Auth::login($authUser);

        return redirect()->route('dashboard');
    }
}
