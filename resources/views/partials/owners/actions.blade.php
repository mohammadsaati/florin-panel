<div class="flex items-center justify-end gap-1.5">
    <a href="{{ route('admin.owners.edit', $row->id) }}" class="btn btn-sm btn-icon btn-primary" title="ویرایش">
        <i class="ki-filled ki-pencil"></i>
    </a>

    <form action="{{ route('admin.owners.toggleStatus', $row->id) }}" method="POST" class="inline">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-icon {{ $row->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $row->is_active ? 'غیرفعال‌کردن' : 'فعال‌سازی' }}">
            <i class="ki-filled {{ $row->is_active ? 'ki-eye-slash' : 'ki-eye' }}"></i>
        </button>
    </form>

    <form action="{{ route('admin.owners.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این سالن مطمئنید؟')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-icon btn-danger" title="حذف">
            <i class="ki-filled ki-trash"></i>
        </button>
    </form>
</div>
