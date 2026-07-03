@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\UserTypeEnum;
    use App\Enums\FormMethodEnum;
    use App\Models\User;

@endphp

<x-panel-layout title="ایجاد کاربر" sub-title="مدیریت کاربران">
    <x-card.form
        action="{{ route('users.update', $user->id) }}"
        :method="FormMethodEnum::POST"
        title="ویرایش کاربر"
        icon="ki-filled ki-user-edit"
        :cols="2"
        :submit="SubmitBtnData::create('ویرایش کاربر')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('users.index'))"
    >

        <x-form.input
            name="first_name"
            label="نام"
            placeholder="نام کاربر را وارد کنید"
            leading-icon="ki-filled ki-user"
            :required="true"
            value="{{ old('first_name', $user->first_name) }}"
        />
        <x-form.input
            name="last_name"
            label="نام خانوادگی"
            placeholder="نام خانوادگی کاربر را وارد کنید"
            leading-icon="ki-filled ki-user"
            :required="true"
            value="{{ old('last_name', $user->last_name) }}"
        />


        <x-form.input
            name="mobile"
            label="شماره موبایل"
            placeholder="مثال: ۰۹۱۲۱۲۳۴۵۶۷"
            leading-icon="ki-filled ki-phone"
            hint="بدون خط تیره وارد کنید"
            :required="true"
            value="{{ old('mobile', $user->mobile) }}"
        />

        <x-date-picket
            name="birth_date"
            label="تاریخ تولد"
            placeholder="انتخاب تاریخ تولد"
            leading-icon="ki-filled ki-calendar"
            :can-select-time="false"
            value="{{ old('birth_date', convert_carbon_to_jalali($user->birth_date)) }}"
        />

        <x-form.select
            name="gender"
            label="جنسیت"
            placeholder="انتخاب جنسیت"
            :options="\App\Enums\UserGenderEnum::toSimpleKeyValue()"
            selected="{{ old('gender', $user->gender->value) }}"
        />


        <x-form.input
            name="referral_code"
            type="text"
            label="کد دعوت"
            value="{{ $referral_code }}"
            leading-icon="ki-filled ki-sms"
            value="{{ old('referral_code', $user->referral_code) }}"
        />


        <x-form.input
            name="invited_by"
            type="text"
            label="کد دعوت کاربر دیگر"
            value="{{ old('invited_by') }}"
            leading-icon="ki-filled ki-sms"
            value="{{ old('invited_by', $user->invited_by) }}"
        />

        <x-form.select
            name="type"
            label="نوع کاربر"
            :required="true"
            :selected="UserTypeEnum::USER->value"
            :options="UserTypeEnum::toSimpleKeyValue()"
            placeholder="نوع کاربر را انتخاب کنید"
            selected="{{ old('type', $user->type->value) }}"
        />


        <x-form.input
            name="password"
            type="password"
            label="رمز عبور"
            placeholder="رمز عبور را وارد کنید"
            leading-icon="ki-filled ki-key"
            hint="در صورت خالی بودن، رمز عبور تنظیم نخواهد شد."
        />
        <x-form.input
            name="password_confirmation"
            type="password"
            label="تکرار رمز عبور"
            placeholder="رمز عبور را مجدداً وارد کنید"
            leading-icon="ki-filled ki-key"
        />

    </x-card.form>
</x-panel-layout>
