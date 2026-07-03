<?php

namespace App\Models;

use App\DTO\filter\QuestionFilter;
use App\DTO\user\CreateQuestionData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 *
 * @property Collection<int, Answer> $answers
 *
 * @method static Builder|Question query()
 */
class Question extends Model
{
    protected $guarded = ['id'];


    /**
     * @return HasMany<Answer, $this>
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }


    /**
     * @return Paginator<int, Question>
     */
    public static function filter(QuestionFilter $filter): Paginator
    {
        return self::query()
            ->simplePaginate(
                perPage: $filter->per_page,
                page: $filter->page,
            )
            ->withQueryString();
    }

    public static function create(CreateQuestionData $data): Question|null
    {
        try {
            DB::beginTransaction();
                $new = new self();
                $new->question = $data->question;
                $new->save();

                foreach ($data->answers as $answer) {
                    $newAnswer = new Answer();
                    $newAnswer->question_id = $new->id;
                    $newAnswer->answer = $answer['answer'];
                    $newAnswer->save();
                }
            DB::commit();

            return $new;
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $e) {
                return null;
            }
            return null;
        }
    }
}
