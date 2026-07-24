@php
    use App\Models\User;
@endphp

<div>
    <div class="flex flex-wrap items-end gap-4 px-5 py-4 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-t-xl">

        <input type="hidden" value="{{ request()->get('user_id') }}" wire:model.live.debounce.300ms="user_id">
        <input type="hidden" value="{{ request()->get('invited_by') }}" wire:model.live.debounce.300ms="invited_by">

        <div class="flex flex-col gap-1.5">
            <div class="input flex items-center gap-2 w-64 border-gray-200 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition">
                <i class="ki-filled ki-magnifier text-gray-400 shrink-0"></i>
                <input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="نام یا موبایل مشتری…"
                    class="grow bg-transparent outline-none text-sm placeholder:text-gray-400"
                />
            </div>
        </div>

        <div class="flex flex-col gap-1.5">
            <div class="input flex items-center gap-2 w-64 border-gray-200 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition">
                <i class="ki-filled ki-user-square text-gray-400 shrink-0"></i>
                <input
                    type="search"
                    wire:model.live.debounce.300ms="referralCode"
                    placeholder="کد دعوت"
                    class="grow bg-transparent outline-none text-sm placeholder:text-gray-400"
                />
            </div>
        </div>

    </div>

    <x-data-table title="لیست کاربران">
        <x-slot:actions>
            <x-button href="{{ route('users.create') }}" size="sm" icon="ki-filled ki-user-edit">کاربر جدید</x-button>
        </x-slot:actions>

        <x-slot:head>
            <x-datatable-heading class="w-16">#</x-datatable-heading>
            <x-datatable-heading>نام کاربر</x-datatable-heading>
            <x-datatable-heading>تاریخ تولد</x-datatable-heading>
            <x-datatable-heading>شماره</x-datatable-heading>
            <x-datatable-heading>کد دعوت</x-datatable-heading>
            <x-datatable-heading>دعوت شده توسط</x-datatable-heading>
            <x-datatable-heading class="w-24 text-end"></x-datatable-heading>
        </x-slot:head>

        @forelse($users as /**@var User $user */ $user)
            <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-primary/5 transition-colors">
                <x-datatable-column :item="$user" field="id" class="text-gray-400 font-mono" />
                <td>{{ $user->getName() }}</td>
                <td>{{ convert_carbon_to_jalali($user->birth_date) }}</td>
                <x-datatable-column :item="$user" field="mobile"/>
                <x-datatable-column :item="$user" field="referral_code"/>
                <td>
                    @php
                        /** @var User|null $invited_user */
                        $invited_user = $user->showInvitedBy()
                    @endphp
                    @if(empty($invited_user))
                        -
                    @else
                        {{ $invited_user->getName() }}
                    @endif
                </td>
                <td>
                    <div class="flex flex-col sm:flex-row gap-2 w-full">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="btn btn-outline btn-sm btn-primary w-full sm:w-auto justify-center">
                            <i class="ki-filled ki-message-edit"></i>
                            <span>ویرایش</span>
                        </a>

                        <a href="{{ route('users.index', ['invited_by' => $user->referral_code]) }}"
                           class="btn btn-outline btn-sm btn-info w-full sm:w-auto justify-center">
                            <i class="ki-filled ki-user-tick"></i>
                            <span>دعوت‌ها</span>
                        </a>

                        <a href="{{ route('users.survey', $user->id) }}"
                           class="btn btn-outline btn-sm btn-success w-full sm:w-auto justify-center">
                            <i class="ki-filled ki-questionnaire-tablet"></i>
                            <span>نظرسنجی</span>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                    <div class="flex flex-col items-center gap-2">
                        <i class="ki-filled ki-user text-4xl opacity-40"></i>
                        <p class="text-sm">کاربری یافت نشد</p>
                    </div>
                </td>
            </tr>
        @endforelse

    </x-data-table>

    <x-table.footer
        :paginator="$users"
        :per-page="$perPage"
    />
</div>
