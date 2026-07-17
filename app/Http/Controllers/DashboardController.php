<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        public UserServiceInterface $userService
    ) {
    }

    public function dashboard(): View
    {
        $todayBirthDays = $this->userService->getTodayBirthdays();

        return view('admin.dashboard.dashboard', compact('todayBirthDays'));
    }
}
