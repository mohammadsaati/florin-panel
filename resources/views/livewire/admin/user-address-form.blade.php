<div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">

    <div class="col-span-2 border-t border-gray-200 dark:border-gray-700 pt-4 mt-1">
        <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 flex items-center gap-2">
            <i class="ki-filled ki-geolocation text-primary"></i>
            آدرس کاربر
        </h4>
    </div>

    {{-- Province --}}
    <div class="flex flex-col gap-1">
        <label class="form-label">استان</label>
        <livewire:components.custom-select
            :options="$provinces"
            name="address[province_id]"
            placeholder="استان را انتخاب کنید"
            :selected="$provinceId ? [$provinceId] : []"
            :clearable="true"
            :searchable="true"
        />
        @error('address.province_id')
            <p class="text-danger text-xs mt-0.5">{{ $message }}</p>
        @enderror
    </div>

    {{-- City — keyed to province so it resets when province changes --}}
    <div class="flex flex-col gap-1">
        <label class="form-label">شهر</label>
        <livewire:components.custom-select
            :key="'city-select-' . ($provinceId ?? 'none')"
            :options="$cities"
            name="address[city_id]"
            :placeholder="$provinceId ? 'شهر را انتخاب کنید' : 'ابتدا استان را انتخاب کنید'"
            :disabled="!$provinceId"
            :selected="old('address.city_id') ? [old('address.city_id')] : []"
            :searchable="true"
        />
        @error('address.city_id')
            <p class="text-danger text-xs mt-0.5">{{ $message }}</p>
        @enderror
    </div>

    <x-form.textarea
        name="address[address]"
        label="آدرس دقیق"
        placeholder="خیابان، کوچه، پلاک و واحد را وارد کنید"
        :rows="3"
        class="col-span-2"
    />

    <x-form.input
        name="address[postal_code]"
        label="کد پستی"
        placeholder="۱۰ رقم بدون خط تیره"
        leading-icon="ki-filled ki-geolocation"
        hint="کد پستی ۱۰ رقمی"
    />

</div>
