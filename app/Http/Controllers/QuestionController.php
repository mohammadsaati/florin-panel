<?php

namespace App\Http\Controllers;

use App\DTO\user\CreateQuestionData;
use App\Http\Requests\Question\CreateRequest;
use App\Http\Requests\Question\UpdateAnswerRequest;
use App\Http\Requests\Question\UpdateRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Services\user\QuestionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Laravel\Prompts\number;

class QuestionController extends Controller
{
    public function __construct(
        private readonly QuestionService $questionService
    )
    {
    }

    public function index(): View
    {
        return view('admin.questions.index');
    }

    public function edit(Question $question): View
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function create(): View
    {
        return view('admin.questions.create');
    }

    public function store(CreateRequest $request)
    {
        /**
         * @var array<int, string> $answers
         */
       $answers = $request->array('answers');

       /** @var array<int, array{
        *   title: string,
        *   is_correct: int
        * }>  $answerDTO
        */
       $answerDTO = [];

       foreach ($answers as $answer) {
           $answerDTO = array_merge($answerDTO, [CreateQuestionData::answerData(answer: $answer)]);
       }

       $this->questionService->createQuestion(new CreateQuestionData(
           question: $request->string('question')->value(),
           priority: null,
           answers: $answerDTO,
       ));

       return redirect()->route('questions.index')->with('success', 'با موفقیت انجام شد');
    }

    public function update(Question $question, UpdateRequest $request): RedirectResponse
    {
        return redirect()->back()->withInput()->with('success', 'با موفقیت انجام شد');
    }

    public function updateAnswer(Answer $answer, UpdateAnswerRequest $request): RedirectResponse
    {

        $this->questionService->updateAnswer(
            $answer,
            $request->string('answer')->value(),
        );

        return redirect()->back()->withInput()->with('success', 'با موفقیت انجام شد');
    }

    public function deleteAnswer(Answer $answer): RedirectResponse
    {
        $this->questionService->deleteAnswer($answer);

        return redirect()->back()->withInput()->with('success', 'با موفقیت انجام شد');
    }
}
