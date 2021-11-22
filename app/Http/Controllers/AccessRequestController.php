<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Environment;
use Illuminate\Http\Request;
use App\Services\AccessRequest\AccessRequestService;
use App\Services\ValidationException;

class AccessRequestController extends Controller
{
    public function __construct(
        protected AccessRequestService $accessRequestService
    ) {}

    public function accessRequest()
    {
        $applications = Application::with('applicationInstances.environment')->get();
        $environments = Environment::get();


        return view('access-request.index', [
            'applications' => $applications,
            'environments' => $environments,
        ]);
    }

    public function saveAccessRequest(Request $request)
    {
        try {
            //Coerce the checkboxes to nicer arrays: ['read'=>'on', 'write'=>'on'] to ['read', 'write'];
            $instances = $request->get('application_instance');
            array_walk($instances, function(&$access, $instanceId) {
                $access = array_keys($access);
            });

            $data = array_merge(['user_id' => \Auth::user()->id], ['application_instances' => $instances]);
            $access = $this->accessRequestService->save($data);
            return redirect()->route('dashboard')->with('success', 'Access request submitted');
        } catch (ValidationException $e) {
            return redirect()->route('access-request')
                ->withInput()
                ->withErrors($e->getErrors());
        }
    }
}
