<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Services\ValidationException;

class UserController extends Controller
{
    public function __construct(
        private UserService $profileService
    ) {}

    public function profile()
    {
        $user = \Auth::user();
        return view('profile.profile', [
            'user' => $user,
        ]);
    }

    public function saveProfile(Request $request)
    {
        try {
            $data = array_merge($request->post(), ['id' => \Auth::user()->id]);
            $this->profileService->save($data);
            return redirect()->route('profile')->with('success', 'Profile updated');
        } catch (ValidationException $e) {
            return redirect()->route('profile')
                ->withInput()
                ->withErrors($e->getErrors());
        }
    }
}
