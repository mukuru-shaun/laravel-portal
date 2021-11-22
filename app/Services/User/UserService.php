<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Crypt\Common\PublicKey;
use phpseclib3\Crypt\PublicKeyLoader;
use App\Services\ValidationException;

class UserService
{
    public function findUserByEmail(string $email): ?User
    {
        return $authUser = User::where('email', '=', $email)->first();
    }

    public function createUser(
        string $name,
        string $email,
        string $provider,
        string $providerId,
    ) {
        $validation = Validator::make([
            'name' => $name,
            'email' => $email,
            'provider' => $provider,
            'providerId' => $providerId,
        ], [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'provider' => ['required', 'string'],
            'providerId' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            throw (new ValidationException())->setErrors($validation->errors());
        }

        return User::create([
            'name' => $name,
            'email' => $email,
            'provider' => $provider,
            'provider_id' => $providerId,
        ]);
    }

    public function save(array $data) {
        $validation = Validator::make($data, [
            'id' => [
                'exists:users,id'
            ],
            'public_key' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    try {
                        $key = PublicKeyLoader::load($value);
                        if (!$key instanceof PublicKey) {
                            $fail('The '.$attribute.' is not a valid public key.');
                        }
                    } catch (\Throwable $e) {
                        $fail('The '.$attribute.' is not a valid public key.');
                    }
                }
            ],
        ]);

        if ($validation->fails()) {
            throw (new ValidationException())->setErrors($validation->errors());
        }

        $user = User::find($data['id']);
        $user->public_key = $data['public_key'] ?? null;
        $user->save();
        return $user;
    }
}
