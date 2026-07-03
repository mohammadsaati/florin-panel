<div class="flex items-center justify-end gap-1.5">

    @if($row->status->value === 'pending')
        <form action="{{ route($routePrefix . '.bookings.updateStatus', $row->id) }}" method="POST" class="inline">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="confirmed">
            <button type="submit" class="btn btn-sm btn-icon btn-success" title="تأیید">
                <i class="ki-filled ki-check"></i>
            </button>
        </form>
        <button
            type="button"
            class="btn btn-sm btn-icon btn-danger"
            title="رد کردن"
            data-modal-toggle="modal-reject-{{ $row->id }}"
        >
            <i class="ki-filled ki-cross"></i>
        </button>
    @endif

    @if(in_array($row->status->value, ['pending','confirmed']))
        <button
            type="button"
            class="btn btn-sm btn-icon btn-warning"
            title="لغو"
            data-modal-toggle="modal-cancel-{{ $row->id }}"
        >
            <i class="ki-filled ki-minus-circle"></i>
        </button>
        <button
            type="button"
            class="btn btn-sm btn-icon btn-light"
            title="انتقال متخصص"
            data-modal-toggle="modal-reassign-{{ $row->id }}"
        >
            <i class="ki-filled ki-arrows-circle"></i>
        </button>
    @endif

    {{-- Reject Modal --}}
    <x-modal id="modal-reject-{{ $row->id }}" title="رد کردن رزرو">
        <form action="{{ route($routePrefix . '.bookings.updateStatus', $row->id) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="rejected">
            <x-form.textarea name="reason" label="دلیل رد (اختیاری)" rows="3" />
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="btn btn-light" data-modal-dismiss="modal-reject-{{ $row->id }}">انصراف</button>
                <button type="submit" class="btn btn-danger">رد کردن</button>
            </div>
        </form>
    </x-modal>

    {{-- Cancel Modal --}}
    <x-modal id="modal-cancel-{{ $row->id }}" title="لغو رزرو">
        <form action="{{ route($routePrefix . '.bookings.cancel', $row->id) }}" method="POST">
            @csrf @method('PATCH')
            <x-form.textarea name="reason" label="دلیل لغو" rows="3" :required="true" />
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="btn btn-light" data-modal-dismiss="modal-cancel-{{ $row->id }}">انصراف</button>
                <button type="submit" class="btn btn-warning">لغو رزرو</button>
            </div>
        </form>
    </x-modal>

    {{-- Reassign Modal --}}
    <x-modal id="modal-reassign-{{ $row->id }}" title="انتقال به متخصص دیگر">
        <form action="{{ route($routePrefix . '.bookings.reassign', $row->id) }}" method="POST">
            @csrf @method('PATCH')
            <x-form.select
                name="staff_id"
                label="متخصص جدید"
                :required="true"
                :options="\App\Models\Staff::active()->pluck('name','id')->toArray()"
                placeholder="انتخاب کنید"
            />
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="btn btn-light" data-modal-dismiss="modal-reassign-{{ $row->id }}">انصراف</button>
                <button type="submit" class="btn btn-primary">انتقال</button>
            </div>
        </form>
    </x-modal>
</div>
