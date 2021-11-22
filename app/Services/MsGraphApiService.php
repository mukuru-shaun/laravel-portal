<?php

namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Directory;

class MsGraphApiService
{
    public function __construct(
        private Graph $graphClient
    )
    {}

    public function getManager(): Directory
    {
        $token = session('azureToken');

        $manager = $this->graphClient->setAccessToken($token)
            ->createRequest('GET', '/me/manager')
            ->setReturnType(Directory::class)
            ->execute();

        return $manager;
    }
}
