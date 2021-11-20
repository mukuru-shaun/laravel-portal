<?php

namespace App\Http\Controllers;

use App\Models\ExternalAccount;
use Illuminate\Http\Request;
use Socialite;

class ExternalAccountController extends Controller
{
    private $providers = [
        'github' => 'Github',
        'gitlab' => 'Gitlab',
    ];

    public function accountsList()
    {
        $user = \Auth::user();
        $externalAccounts = $user->externalAccounts();

        $providers = $this->providers;
        array_walk($providers, function(&$item, $key) use($externalAccounts) {
            $collection = clone $externalAccounts;
            $item = [
                'name' => $item,
                'key' => $key,
                'account' => $collection->where('provider', $key)->first()
            ];
        });

        return view('external-accounts.list', [
            'providers' => $providers
        ]);
    }

    public function redirect(Request $request, string $provider)
    {
        if (!array_key_exists($provider, $this->providers)) {
            throw new \Exception(sprintf('Invalid provider "%s"', $provider));
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, string $provider)
    {
        if (!array_key_exists($provider, $this->providers)) {
            throw new \Exception(sprintf('Invalid provider "%s"', $provider));
        }

        $providerUser = Socialite::driver($provider)->user();

        $externalAccount = (new ExternalAccount())
            ->where('user_id', \Auth::user()->id)
            ->where('provider', $provider)
            ->first();

        if (!$externalAccount) {
            $externalAccount = new ExternalAccount([
                'user_id' => \Auth::user()->id,
                'provider' => $provider,
            ]);
        }
        $externalAccount->username = $providerUser->getNickname();
        $externalAccount->save();

        return redirect()->route('external-accounts')
            ->with('success', 'Account successfully linked');
    }
}
