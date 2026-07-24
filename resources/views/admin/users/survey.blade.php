@php
    use App\Models\User;
    use App\Models\Question;
    use App\Models\Survey;
@endphp

<x-panel-layout title="پاسخ‌های نظرسنجی" sub-title="مدیریت کاربران">

    <div class="flex flex-col gap-6">

        {{-- User info card --}}
        <div class="card">
            <div class="card-header">
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-pink-400 to-rose-600 text-white text-2xl shadow-lg">
                        👤
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            {{ $user->getName() }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            <i class="ki-filled ki-phone text-pink-400 ml-1"></i>
                            {{ $user->mobile }}
                        </p>
                    </div>
                    <div class="mr-auto flex items-center gap-3">
                        @php $answeredCount = $previousAnswers->count(); @endphp
                        <span class="badge badge-pill
                            {{ $answeredCount > 0 ? 'badge-success' : 'badge-warning' }}">
                            {{ $answeredCount }} / {{ $questions->count() }} پاسخ داده
                        </span>
                        <a href="{{ route('users.index') }}"
                           class="btn btn-outline btn-sm btn-secondary">
                            <i class="ki-filled ki-arrow-right"></i>
                            بازگشت
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Questions & answers --}}
        @if($questions->isEmpty())
            <div class="card">
                <div class="card-body flex flex-col items-center justify-center py-16 gap-3 text-gray-400">
                    <i class="ki-filled ki-questionnaire-tablet text-5xl opacity-30"></i>
                    <p class="text-sm">هیچ سوالی در سیستم ثبت نشده است.</p>
                </div>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach($questions as $index => $question)
                @php
                    /** @var Survey|null $userAnswer */
                    $userAnswer = $previousAnswers->get($question->id);
                @endphp
                <div class="card">
                    <div class="card-body p-5">

                        {{-- Question header --}}
                        <div class="flex items-start gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full
                                         bg-gradient-to-br from-pink-400 to-rose-500
                                         text-white text-xs font-bold flex-shrink-0 shadow">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm leading-relaxed">
                                    {{ $question->question }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                @if($userAnswer)
                                    <span class="badge badge-pill badge-success text-xs">
                                        <i class="ki-filled ki-check-circle ml-1"></i>
                                        پاسخ داده شده
                                    </span>
                                @else
                                    <span class="badge badge-pill badge-warning text-xs">
                                        <i class="ki-filled ki-information-2 ml-1"></i>
                                        بی‌پاسخ
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Answers --}}
                        @if($question->answers->isNotEmpty())
                        <div class="flex flex-col gap-2 pr-11">
                            @foreach($question->answers as $answer)
                            @php
                                $isChosen = $userAnswer && $userAnswer->answer_id === $answer->id;
                            @endphp
                            <div class="flex items-center gap-3 px-4 py-2.5 rounded-xl border transition-all
                                {{ $isChosen
                                    ? 'bg-gradient-to-l from-pink-50 to-rose-50 border-rose-300 dark:from-pink-900/20 dark:to-rose-900/20 dark:border-rose-500/40'
                                    : 'bg-gray-50 border-gray-200 dark:bg-gray-800/40 dark:border-gray-700' }}">

                                {{-- Indicator --}}
                                <div class="flex-shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center
                                    {{ $isChosen ? 'border-rose-500 bg-rose-500' : 'border-gray-300 dark:border-gray-600' }}">
                                    @if($isChosen)
                                        <svg width="10" height="10" viewBox="0 0 12 12" fill="none">
                                            <path d="M2 6L5 9L10 3" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </div>

                                <span class="text-sm {{ $isChosen ? 'font-semibold text-rose-700 dark:text-rose-400' : 'text-gray-600 dark:text-gray-400' }}">
                                    {{ $answer->answer }}
                                </span>

                                @if($isChosen)
                                    <span class="mr-auto text-xs font-medium text-rose-500 dark:text-rose-400 flex items-center gap-1">
                                        <i class="ki-filled ki-user-square text-xs"></i>
                                        انتخاب کاربر
                                    </span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                            <p class="text-xs text-gray-400 pr-11 italic">گزینه‌ای برای این سوال تعریف نشده است.</p>
                        @endif

                    </div>
                </div>
                @endforeach
            </div>
        @endif

        {{-- Summary if answered --}}
        @if($previousAnswers->count() > 0)
        <div class="card">
            <div class="card-body p-5">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                    <i class="ki-filled ki-chart-pie text-pink-500"></i>
                    خلاصه پاسخ‌ها
                </h3>
                <div class="flex flex-col gap-2">
                    @foreach($previousAnswers as $qId => $survey)
                    <div class="flex items-center gap-2 text-sm">
                        <i class="ki-filled ki-check-circle text-green-500 flex-shrink-0"></i>
                        <span class="text-gray-500 dark:text-gray-400 min-w-0 truncate">
                            {{ $survey->question->question }}
                        </span>
                        <span class="text-gray-300 dark:text-gray-600 flex-shrink-0">←</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200 flex-shrink-0">
                            {{ $survey->answer->answer }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>

</x-panel-layout>
