@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
@endphp

<x-panel-layout title="ویرایش شهر" sub-title="مدیریت جغرافیایی">
    <x-card.form
        action="{{ route('cities.update', $city) }}"
        :method="FormMethodEnum::POST"
        title="ویرایش شهر: {{ $city->name }}"
        icon="ki-filled ki-map"
        :submit="SubmitBtnData::create('ذخیره تغییرات')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('cities.index'))"
    >
        <x-form.input
            name="name"
            label="نام شهر"
            placeholder="نام شهر را وارد کنید"
            leading-icon="ki-filled ki-geolocation"
            :value="$city->name"
            :required="true"
        />
        <x-form.select
            name="province_id"
            label="استان"
            leading-icon="ki-filled ki-map"
            placeholder="استان را انتخاب کنید"
            :options="$provinces->toArray()"
            :selected="$city->province_id"
            :required="true"
        />
    </x-card.form>
</x-panel-layout>
