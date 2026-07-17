@php
    use App\DTO\form\SubmitBtnData;
    use App\Enums\FormMethodEnum;
    use App\Models\User;
@endphp

<x-panel-layout
    title="داشبورد"
>

    <div class="my-3">
        <x-card.form
            action="{{ route('users.send-birth-day-sms') }}"
            :method="FormMethodEnum::POST"
            title="تولد های امروز"
            icon="ki-filled ki-emoji-happy"
            :submit="SubmitBtnData::create('ارسال پیام')"
            :cancel="SubmitBtnData::create('انصراف', 'secondary')"
        >
            @if(!count($todayBirthDays))
                <div class="flex flex-col items-center gap-2">
                    <i class="ki-filled ki-user text-4xl opacity-40"></i>
                    <p class="text-sm">کاربری یافت نشد</p>
                </div>
            @else
                <div class="grid grid-cols-3 items-center justify-start gap-4">

                    @foreach($todayBirthDays as /** @var User $user*/ $user)
                        <x-form.checkbox
                            name="user_ids[]"
                            :value="$user->id"
                            :label="$user->getName()"
                            :checked="true"
                        />
                    @endforeach
                </div>
            @endif

        </x-card.form>
    </div>

</x-panel-layout>
