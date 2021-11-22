<?php

namespace Portal\AccessRequest;

use App\Models\ApplicationInstance;
use App\Models\ApplicationInstanceAccessRequest;
use App\Models\Environment;
use App\Models\User;
use Illuminate\Validation\Factory;
use Portal\MsGraphApiService;
use Portal\ValidationException;

class AccessRequestService
{
    public function __construct(
        private Factory $validationFactory,
        private MsGraphApiService $graphApiService
    ) {}

    public function save(array $data): ApplicationInstanceAccessRequest
    {
        $validation = $this->validationFactory->make($data, [
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'application_instances' => [
                'required',
            ],
            'application_instances.*' => [
                function ($attribute, $value, $fail) {
                    list(,$instanceId) = explode('.', $attribute);

                    // check it exists (the exists rule doesn't seem to work well for nested arrays
                    $instance = ApplicationInstance::find($instanceId);
                    if (!$instance) {
                        $fail('An invalid application instance was selected');
                    }

                    // check there's not write access on prod trying to sneak in
                    if ($instance->environment->name === Environment::PRODUCTION && in_array('write', $value)) {
                        $fail('An invalid access request for an application instance was selected');
                    }
                }
            ],
        ], [
            'application_instance.required' => 'Please select which instances you would like to request access to'
        ]);

        if ($validation->fails()) {
            throw (new ValidationException())->setErrors($validation->errors());
        }

        //TODO, extract this into the user service
        $manager = $this->graphApiService->getManager();
        $managerUser = User::where('email', $manager->getProperties()['mail'])->first();

        if (!$managerUser) {
            $managerUser = User::create([
                'name' => $manager->getProperties()['displayName'],
                'email' => $manager->getProperties()['mail'],
                'provider' => 'azure',
                'provider_id' => $manager->getId(),
            ]);
        }

        return ApplicationInstanceAccessRequest::create([
            'user_id' => \Auth::user()->id,
            'manager_user_id' => $managerUser->id,
            'status' => ApplicationInstanceAccessRequest::STATUS_PENDING,
            'requested_access' => json_encode($data['application_instances'])
        ]);
    }
}
