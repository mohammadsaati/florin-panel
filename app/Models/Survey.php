<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property int $answer_id
 * @property Answer $answer
 * @property Question $question
 */
class Survey extends Model
{
    protected $guarded = ['id'];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Question, $this> */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /** @return BelongsTo<Answer, $this> */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    /**
     * Save or update a single answer for a user/question pair.
     */
    public static function upsertAnswer(int $userId, int $questionId, int $answerId): void
    {
        self::updateOrCreate(
            ['user_id' => $userId, 'question_id' => $questionId],
            ['answer_id' => $answerId],
        );
    }

    /**
     * @return Collection<int, Survey>
     */
    public static function getForUser(int $userId): Collection
    {
        return self::query()
            ->with(['question.answers', 'answer'])
            ->where('user_id', $userId)
            ->get()
            ->keyBy('question_id');
    }
}
