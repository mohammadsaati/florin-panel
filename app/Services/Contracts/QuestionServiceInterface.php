<?php

namespace App\Services\Contracts;

use App\DTO\filter\QuestionFilter;
use App\DTO\user\CreateQuestionData;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Pagination\Paginator;

interface QuestionServiceInterface
{
    /**
     * Create question
     */
    public function createQuestion(CreateQuestionData $data): Question|null;

    /**
     * @return Paginator<int, Question>
     */
    public function filter(QuestionFilter $filter): Paginator;

    /**
     * Update question answer
     */
    public function updateAnswer(Answer $answer, string $newAnswer): Answer;

    /**
     * Delete question answer
     */
    public function deleteAnswer(Answer $answer): bool;

}
