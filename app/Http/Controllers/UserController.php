<?php

namespace App\Http\Controllers;

use App\DTO\user\CreateData;
use App\Http\Requests\User\CreateRequest;
use App\Models\User;
use App\Services\Contracts\CityServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly CityServiceInterface $cityService,
    ) {}

    public function index(): View
    {
        return view('admin.users.index');
    }

    public function create(): View
    {
        $referral_code = $this->userService->generateReferralCode();
        $provinces     = $this->cityService->getProvincesForSelect();

        return view('admin.users.create', compact('referral_code', 'provinces'));
    }

    public function edit(User $user): View
    {
        $provinces     = $this->cityService->getProvincesForSelect();

        return view('admin.users.edit', compact('user', 'provinces'));
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $this->userService->create(CreateData::fromRequest($request));

        return redirect()->route('users.index');
    }
}
