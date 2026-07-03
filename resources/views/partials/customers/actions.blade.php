<div class="flex items-center justify-end gap-1.5">
    <a href="{{ route($routePrefix . '.customers.show', $row->id) }}" class="btn btn-sm btn-icon btn-primary" title="مشاهده پروفایل">
        <i class="ki-filled ki-eye"></i>
    </a>

    <button
        type="button"
        class="btn btn-sm btn-icon {{ $row->is_blocked ? 'btn-success' : 'btn-danger' }}"
        title="{{ $row->is_blocked ? 'رفع مسدودیت' : 'مسدود کردن' }}"
        data-modal-toggle="modal-block-{{ $row->id }}"
    >
        <i class="ki-filled {{ $row->is_blocked ? 'ki-check' : 'ki-ban' }}"></i>
    </button>

    <x-modal id="modal-block-{{ $row->id }}" :title="$row->is_blocked ? 'رفع مسدودیت' : 'مسدود کردن مشتری'">
        <form action="{{ route($routePrefix . '.customers.block', $row->id) }}" method="POST">
            @csrf @method('PATCH')
            @if(!$row->is_blocked)
                <x-form.textarea name="reason" label="دلیل مسدودیت" rows="3" :required="true" />
            @else
                <p class="text-sm text-gray-600">آیا مطمئن هستید که می‌خواهید مسدودیت <strong>{{ $row->full_name }}</strong> را رفع کنید؟</p>
                <input type="hidden" name="reason" value="">
            @endif
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="btn btn-light" data-modal-dismiss="modal-block-{{ $row->id }}">انصراف</button>
                <button type="submit" class="btn {{ $row->is_blocked ? 'btn-success' : 'btn-danger' }}">
                    {{ $row->is_blocked ? 'رفع مسدودیت' : 'مسدود کردن' }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
