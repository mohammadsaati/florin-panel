@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\UserTypeEnum;
    use App\Enums\FormMethodEnum;
@endphp

<x-panel-layout title="ایجاد کاربر" sub-title="مدیریت کاربران">
    <x-card.form
        action="{{ route('users.store') }}"
        :method="FormMethodEnum::POST"
        title="افزودن کاربر جدید"
        icon="ki-filled ki-user-edit"
        :cols="2"
        :submit="SubmitBtnData::create('ذخیره کاربر')"
        :cancel="SubmitBtnData::create('انصراف', 'secondary', false, route('users.index'))"
    >

        <x-form.input
            name="first_name"
            label="نام"
            placeholder="نام کاربر را وارد کنید"
            leading-icon="ki-filled ki-user"
            :required="true"
        />
        <x-form.input
            name="last_name"
            label="نام خانوادگی"
            placeholder="نام خانوادگی کاربر را وارد کنید"
            leading-icon="ki-filled ki-user"
            :required="true"
        />


        <x-form.input
            name="mobile"
            label="شماره موبایل"
            placeholder="مثال: ۰۹۱۲۱۲۳۴۵۶۷"
            leading-icon="ki-filled ki-phone"
            hint="بدون خط تیره وارد کنید"
            :required="true"
        />

        <x-date-picket
            name="birth_date"
            label="تاریخ تولد"
            placeholder="انتخاب تاریخ تولد"
            leading-icon="ki-filled ki-calendar"
            :can-select-time="false"
            value="{{ old('birth_date') }}"
        />

        <x-form.select
            name="gender"
            label="جنسیت"
            placeholder="انتخاب جنسیت"
            :options="\App\Enums\UserGenderEnum::toSimpleKeyValue()"
            value="{{ old('gender') }}"
        />


        <x-form.input
            name="referral_code"
            type="text"
            label="کد دعوت"
            value="{{ $referral_code }}"
            leading-icon="ki-filled ki-sms"
        />


        <x-form.input
            name="invited_by"
            type="text"
            label="کد دعوت کاربر دیگر"
            value="{{ old('invited_by') }}"
            leading-icon="ki-filled ki-sms"
        />

        <x-form.select
            name="type"
            label="نوع کاربر"

            :required="true"
            :selected="UserTypeEnum::USER->value"
            :options="[
                UserTypeEnum::USER->value  => 'کاربر عادی',
                UserTypeEnum::ADMIN->value => 'مدیر',
            ]"
            placeholder="نوع کاربر را انتخاب کنید"
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

        <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-4 mt-1">
            <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 flex items-center gap-2">
                <i class="ki-filled ki-geolocation text-primary"></i>
                آدرس کاربر
            </h4>
        </div>

        <x-form.select
            name="address[province_id]"
            label="استان"
            placeholder="استان را انتخاب کنید"
            :options="$provinces->toArray()"
            :selected="old('address.province_id')"
            data-province-select
            data-cities-url="{{ route('cities.by-province', ':id') }}"
        />

        <x-form.select
            name="address[city_id]"
            label="شهر"
            placeholder="ابتدا استان را انتخاب کنید"
            :options="[]"
            :selected="old('address.city_id')"
            :disabled="!old('address.province_id')"
            data-city-select
        />

        <x-form.textarea
            name="address[address]"
            label="آدرس دقیق"
            placeholder="خیابان، کوچه، پلاک و واحد را وارد کنید"
            :rows="3"
            class="md:col-span-2"
        />

        <x-form.input
            name="address[postal_code]"
            label="کد پستی"
            placeholder="۱۰ رقم بدون خط تیره"
            leading-icon="ki-filled ki-geolocation"
            hint="کد پستی ۱۰ رقمی"
        />

    </x-card.form>

@push('scripts')
<script>
    const provinceSelect = document.querySelector('[data-province-select]');
    const citySelect     = document.querySelector('[data-city-select]');
    const citiesUrl      = provinceSelect.dataset.citiesUrl;
    const oldCity        = '{{ old('address.city_id') }}';

    function loadCities(provinceId, preselectValue) {
        const url = citiesUrl.replace(':id', provinceId);
        fetch(url).then(r => r.json()).then(cities => {
            citySelect.innerHTML = '<option value="">شهر را انتخاب کنید</option>';
            cities.forEach(c => {
                const opt = new Option(c.name, c.id, false, String(c.id) === String(preselectValue));
                citySelect.appendChild(opt);
            });
            citySelect.disabled = false;
        });
    }

    provinceSelect.addEventListener('change', function () {
        if (!this.value) {
            citySelect.innerHTML = '<option value="">ابتدا استان را انتخاب کنید</option>';
            citySelect.disabled = true;
            return;
        }
        loadCities(this.value, null);
    });

    if (provinceSelect.value) {
        loadCities(provinceSelect.value, oldCity);
    }
</script>
@endpush
</x-panel-layout>
