<div class="flex items-center justify-end gap-1.5">
    <a href="{{ route($routePrefix . '.coupons.edit', $row->id) }}" class="btn btn-sm btn-icon btn-primary" title="ویرایش">
        <i class="ki-filled ki-pencil"></i>
    </a>

    <form action="{{ route($routePrefix . '.coupons.toggle', $row->id) }}" method="POST" class="inline">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-icon {{ $row->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $row->is_active ? 'غیرفعال' : 'فعال' }}">
            <i class="ki-filled {{ $row->is_active ? 'ki-eye-slash' : 'ki-eye' }}"></i>
        </button>
    </form>
</div>
