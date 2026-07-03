@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
@endphp

<x-panel-layout title="استان جدید" sub-title="مدیریت جغرافیایی">
    <x-card.form
        action="{{ route('provinces.store') }}"
        :method="FormMethodEnum::POST"
        title="افزودن استان جدید"
        icon="ki-filled ki-map"
        :submit="SubmitBtnData::create('ذخیره استان')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('cities.index'))"
    >
        <x-form.input
            name="name"
            label="نام استان"
            placeholder="نام استان را وارد کنید"
            leading-icon="ki-filled ki-geolocation"
            :required="true"
        />
    </x-card.form>
</x-panel-layout>
