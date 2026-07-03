<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InvalidPasswordException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected readonly UserService $userService,
    ){
    }

    public function loginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }

        try {
            $user = $this->userService->login(
                phone: $request->string('phone')->value(),
                password: $request->string('password')->value()
            );

            Auth::guard('admin')->login($user);

            return redirect()->route('dashboard');
        } catch (UserNotFoundException | InvalidPasswordException) {
            throw ValidationException::withMessages([
                'errors' => [trans('auth.failed')],
            ]);
        }
    }
}
