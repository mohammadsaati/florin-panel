<?php

namespace App\Http\Controllers;

use App\Http\Requests\Survey\PhoneLookupRequest;
use App\Http\Requests\Survey\SubmitRequest;
use App\Models\User;
use App\Services\Contracts\SurveyServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SurveyController extends Controller
{
    public function __construct(private readonly SurveyServiceInterface $surveyService) {}

    public function index(): View
    {
        return view('survey.index');
    }

    public function lookup(PhoneLookupRequest $request): View
    {
        $phone = $request->validated('phone');
        $user  = $this->surveyService->findUserByPhone($phone);

        if (! $user) {
            return view('survey.index', [
                'notFound' => true,
                'phone'    => $phone,
            ]);
        }

        $questions       = $this->surveyService->getAllQuestionsWithAnswers();
        $previousAnswers = $this->surveyService->getUserSurveyAnswers($user->id);

        return view('survey.index', [
            'user'            => $user,
            'questions'       => $questions,
            'phone'           => $phone,
            'previousAnswers' => $previousAnswers,
        ]);
    }

    public function submit(SubmitRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = User::findOrFail($data['user_id']);

        $this->surveyService->submitAnswers($user, $data['answers']);

        return redirect()
            ->route('survey.index')
            ->with('success', 'پاسخ‌های شما با موفقیت ثبت شد. ممنون از نظرسنجی شما! 🌸');
    }
}
