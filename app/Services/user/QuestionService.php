<?php

namespace App\Services\user;

use App\DTO\filter\QuestionFilter;
use App\DTO\user\CreateQuestionData;
use App\Models\Answer;
use App\Models\Question;
use App\Services\Contracts\QuestionServiceInterface;
use Illuminate\Pagination\Paginator;

class QuestionService implements QuestionServiceInterface
{
    /**
     * @inheritDoc
     */
    public function createQuestion(CreateQuestionData $data): Question|null
    {
        return Question::create($data);
    }

    /**
     * @inheritDoc
     */
    public function filter(QuestionFilter $filter): Paginator
    {
        return Question::filter($filter);
    }

    /**
     * @inheritDoc
     */
    public function updateAnswer(Answer $answer, string $newAnswer): Answer
    {
        $answer->update([
            'answer' => $newAnswer
        ]);

        return $answer;
    }


    /**
     * @inheritDoc
     */
    public function deleteAnswer(Answer $answer): bool
    {
        return $answer->delete();
    }
}
