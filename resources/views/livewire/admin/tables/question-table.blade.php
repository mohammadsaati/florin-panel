@php
     use  App\Models\Question;
@endphp

<div>
    <x-datatable title="لیست سوالات">
        <x-slot:actions>
            <x-button href="{{ route('questions.create') }}" size="sm" icon="ki-filled ki-user-edit">سوال جدید</x-button>
        </x-slot:actions>

        <x-slot:head>
            <x-datatable-heading class="w-16">#</x-datatable-heading>
            <x-datatable-heading>سوال</x-datatable-heading>
            <x-datatable-heading class="w-16"></x-datatable-heading>
        </x-slot:head>

        @forelse($questions as /**@var Question  */ $question)
            <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-primary/5 transition-colors">
                <x-datatable-column :item="$question" field="id" class="text-gray-400 font-mono" />
                <x-datatable-column :item="$question" field="question" class="text-gray-400 font-mono" />

                <td>
                    <div class="flex flex-col sm:flex-row gap-2 w-full">
                        <a href="{{ route('questions.edit', $question->id) }}"
                           class="btn btn-outline btn-sm btn-primary w-full sm:w-auto justify-center">
                            <i class="ki-filled ki-message-edit"></i>
                            <span>ویرایش</span>
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
    </x-datatable>
</div>
