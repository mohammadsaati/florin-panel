@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
@endphp

<x-panel-layout
    title="سوال جدید"
    sub-title="سوال جدید برای نطر سنجی"
>

    <x-card.form
        action="{{ route('questions.store') }}"
        :method="FormMethodEnum::POST"
        title="افزودن سوال جدید"
        icon="ki-filled ki-glass"
        :cols="1"
        :submit="SubmitBtnData::create('ذخیره سوال')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('questions.index'))"
    >

        <x-form.input
            name="question"
            label="سوال"
            placeholder=""
            :required="true"
        />

        <x-input-repeater
            title="افزودن جواب"
            name="answers"
            :repeat-items="['answer' => 'text',]"
        />

    </x-card.form>

</x-panel-layout>
