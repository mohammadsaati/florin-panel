@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
@endphp

<x-panel-layout title="شهر جدید" sub-title="مدیریت جغرافیایی">
    <x-card.form
        action="{{ route('cities.store') }}"
        :method="FormMethodEnum::POST"
        title="افزودن شهر جدید"
        icon="ki-filled ki-map"
        :submit="SubmitBtnData::create('ذخیره شهر')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('cities.index'))"
    >
        <x-form.input
            name="name"
            label="نام شهر"
            placeholder="نام شهر را وارد کنید"
            leading-icon="ki-filled ki-geolocation"
            :required="true"
        />
        <x-form.select
            name="province_id"
            label="استان"
            leading-icon="ki-filled ki-map"
            placeholder="استان را انتخاب کنید"
            :options="$provinces->toArray()"
            :required="true"
        />
    </x-card.form>
</x-panel-layout>
