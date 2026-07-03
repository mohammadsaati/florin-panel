@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
    use App\Models\Question;
    /** @var Question $question */
    use App\Models\Answer
@endphp

<x-panel-layout
    title="سوال جدید"
    sub-title="سوال جدید برای نطر سنجی"
>

    <x-card.form
        action="{{ route('questions.update', $question->id) }}"
        :method="FormMethodEnum::POST"
        title="ویرایش سوال"
        icon="ki-filled ki-glass"
        :cols="1"
        :submit="SubmitBtnData::create('ویرایش سوال')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('questions.index'))"
    >

        <x-form.input
            name="question"
            label="سوال"
            placeholder=""
            :required="true"
            value="{{ old('question', $question->question) }}"
        />

    </x-card.form>

    <x-card.simple
        title="جواب ها"
    >
        @foreach($question->answers as /** @var Answer $answer */ $answer)
            <div class="flex justify-between  items-center gap-2 my-2">
                <div class="w-full">
                    <form action="{{ route('questions.answer.update', $answer->id) }}" method="POST">
                        @csrf
                        <div class="flex justify-between items-center gap-2">
                            <x-form.input
                                name="answer"
                                label=""
                                placeholder=""
                                :required="true"
                                value="{{ $answer->answer }}"
                                class="w-full"
                            />

                            <x-button
                                type="submit"
                                variant="outline btn-primary"
                                icon="ki-filled ki-notepad-edit"
                                size="sm"
                            >
                                ویرایش
                            </x-button>
                        </div>
                    </form>
                </div>
                <div>
                    <form action="{{ route('questions.answer.delete', $answer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button
                            type="submit"
                            variant="outline btn-danger"
                            icon="ki-filled ki-trash"
                            size="sm"
                        >
                            حذف
                        </x-button>
                    </form>
                </div>
            </div>
        @endforeach
    </x-card.simple>

</x-panel-layout>
