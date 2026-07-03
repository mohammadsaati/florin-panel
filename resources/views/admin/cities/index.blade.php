<x-panel-layout title="شهرها و استان‌ها" sub-title="مدیریت جغرافیایی">

    @if(session('success'))
        <x-alert type="success" :dismissible="true">{{ session('success') }}</x-alert>
    @endif

    {{-- جدول استان‌ها --}}
    <x-card.table
        title="استان‌ها"
        :headers="['نام استان', 'تعداد شهر', 'عملیات']"
        empty="هیچ استانی ثبت نشده است."
    >
        <x-slot:actions>
            <x-button href="{{ route('provinces.create') }}" variant="primary" size="sm" icon="ki-filled ki-plus">
                استان جدید
            </x-button>
        </x-slot:actions>

        @foreach($provinces as $province)
            <tr>
                <td class="px-5 py-3.5 text-sm text-gray-700">{{ $province->name }}</td>
                <td class="px-5 py-3.5 text-sm">
                    <x-badge variant="primary" pill>{{ $province->cities_count }}</x-badge>
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        <x-button href="{{ route('provinces.edit', $province) }}" variant="light" size="sm" icon="ki-filled ki-pencil">
                            ویرایش
                        </x-button>
                        <form action="{{ route('provinces.delete', $province) }}" method="POST"
                              onsubmit="return confirm('آیا از حذف این استان مطمئن هستید؟ تمام شهرهای مرتبط نیز حذف می‌شوند.')">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" variant="danger" size="sm" icon="ki-filled ki-trash">
                                حذف
                            </x-button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot:pagination>
            <span class="text-sm text-gray-500">
                @if($provinces->firstItem())
                    نمایش {{ $provinces->firstItem() }}–{{ $provinces->lastItem() }} از {{ $provinces->total() }}
                @endif
            </span>
            {{ $provinces->onEachSide(1)->links('pagination::simple-tailwind') }}
        </x-slot:pagination>
    </x-card.table>

    {{-- جدول شهرها --}}
    <x-card.table
        title="شهرها"
        :headers="['نام شهر', 'استان', 'عملیات']"
        empty="هیچ شهری ثبت نشده است."
    >
        <x-slot:actions>
            <x-button href="{{ route('cities.create') }}" variant="primary" size="sm" icon="ki-filled ki-plus">
                شهر جدید
            </x-button>
        </x-slot:actions>

        @foreach($cities as $city)
            <tr>
                <td class="px-5 py-3.5 text-sm text-gray-700 font-medium">{{ $city->name }}</td>
                <td class="px-5 py-3.5 text-sm text-gray-500">{{ $city->province?->name ?? '—' }}</td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        <x-button href="{{ route('cities.edit', $city) }}" variant="light" size="sm" icon="ki-filled ki-pencil">
                            ویرایش
                        </x-button>
                        <form action="{{ route('cities.delete', $city) }}" method="POST"
                              onsubmit="return confirm('آیا از حذف این شهر مطمئن هستید؟')">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" variant="danger" size="sm" icon="ki-filled ki-trash">
                                حذف
                            </x-button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot:pagination>
            <span class="text-sm text-gray-500">
                @if($cities->firstItem())
                    نمایش {{ $cities->firstItem() }}–{{ $cities->lastItem() }} از {{ $cities->total() }}
                @endif
            </span>
            {{ $cities->onEachSide(1)->links('pagination::simple-tailwind') }}
        </x-slot:pagination>
    </x-card.table>

</x-panel-layout>
