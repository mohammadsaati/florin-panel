@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
@endphp

<x-panel-layout title="ویرایش استان" sub-title="مدیریت جغرافیایی">
    <x-card.form
        action="{{ route('provinces.update', $province) }}"
        :method="FormMethodEnum::POST"
        title="ویرایش استان: {{ $province->name }}"
        icon="ki-filled ki-map"
        :submit="SubmitBtnData::create('ذخیره تغییرات')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('cities.index'))"
    >
        <x-form.input
            name="name"
            label="نام استان"
            placeholder="نام استان را وارد کنید"
            leading-icon="ki-filled ki-geolocation"
            :value="$province->name"
            :required="true"
        />
    </x-card.form>
</x-panel-layout>
