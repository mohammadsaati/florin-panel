<?php

namespace App\Services\survey;

use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use App\Services\Contracts\SurveyServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class SurveyService implements SurveyServiceInterface
{
    public function findUserByPhone(string $phone): User|null
    {
        return User::findByPhoneNumber($phone);
    }

    public function getAllQuestionsWithAnswers(): Collection
    {
        return Question::listWithAnswers();
    }

    public function submitAnswers(User $user, array $answers): void
    {
        foreach ($answers as $questionId => $answerId) {
            Survey::upsertAnswer($user->id, (int) $questionId, (int) $answerId);
        }
    }

    public function getUserSurveyAnswers(int $userId): Collection
    {
        return Survey::getForUser($userId);
    }
}
