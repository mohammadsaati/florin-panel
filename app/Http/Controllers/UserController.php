<?php

namespace App\Http\Controllers;

use App\DTO\user\CreateData;
use App\Http\Requests\User\BirthDaySmsRequest;
use App\Http\Requests\User\CreateRequest;
use App\Models\User;
use App\Services\Contracts\CityServiceInterface;
use App\Services\Contracts\SurveyServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly CityServiceInterface $cityService,
        private readonly SurveyServiceInterface $surveyService,
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

    public function survey(User $user): View
    {
        $questions       = $this->surveyService->getAllQuestionsWithAnswers();
        $previousAnswers = $this->surveyService->getUserSurveyAnswers($user->id);

        return view('admin.users.survey', compact('user', 'questions', 'previousAnswers'));
    }

    public function sendBirthDaySms(BirthDaySmsRequest $request): RedirectResponse
    {
        $this->userService->sendBirthdaySmsWithUserIds(
            $request->array('user_ids'),
        );

        return redirect()->back()->with('success', 'پیام با موفقیت ارسال شد');
    }
}
