<?php

namespace App\Services\Contracts;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface SurveyServiceInterface
{
    public function findUserByPhone(string $phone): User|null;

    /** @return Collection<int, \App\Models\Question> */
    public function getAllQuestionsWithAnswers(): Collection;

    /**
     * @param array<int, int> $answers  [question_id => answer_id]
     */
    public function submitAnswers(User $user, array $answers): void;

    /**
     * @return Collection<int, Survey>  keyed by question_id
     */
    public function getUserSurveyAnswers(int $userId): Collection;
}
