<?php

namespace Portal\User;

use App\Models\User;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use phpseclib3\Crypt\Common\PublicKey;
use phpseclib3\Crypt\PublicKeyLoader;
use Portal\ValidationException;

class UserService
{
    public function __construct(
        private Factory $validationFactory
    ) {}

    public function save(array $data) {
        $validation = $this->validationFactory->make($data, [
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
