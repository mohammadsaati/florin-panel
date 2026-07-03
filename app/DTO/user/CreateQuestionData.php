<?php

namespace App\DTO\user;

class CreateQuestionData
{
    /**
     * @param array{
     *     answer: string,
     *     is_correct: int
     * } $answers
     */
    public function __construct(
        public string $question,
        public int|null $priority = null,
        public array $answers,
    )
    {
    }


    /**
     * @return array{
     *     title: string,
     *     is_correct: int
     * } $answers
     */
    public static function answerData(string $answer, int $isCorrect = 0): array
    {
        return [
            'answer' => $answer,
            'priority' => $isCorrect,
        ];
    }
}
