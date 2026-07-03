<div class="flex items-center justify-end gap-1.5">
    <a href="{{ route($routePrefix . '.staff.edit', $row->id) }}" class="btn btn-sm btn-icon btn-primary" title="ویرایش">
        <i class="ki-filled ki-pencil"></i>
    </a>
    <a href="{{ route($routePrefix . '.staff.report', $row->id) }}" class="btn btn-sm btn-icon btn-info" title="گزارش عملکرد">
        <i class="ki-filled ki-chart-line"></i>
    </a>
    <a href="{{ route($routePrefix . '.staff.leaves.index', $row->id) }}" class="btn btn-sm btn-icon btn-light" title="مرخصی‌ها">
        <i class="ki-filled ki-calendar"></i>
    </a>

    <form action="{{ route($routePrefix . '.staff.toggle', $row->id) }}" method="POST" class="inline">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-sm btn-icon {{ $row->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $row->is_active ? 'غیرفعال' : 'فعال' }}">
            <i class="ki-filled {{ $row->is_active ? 'ki-eye-slash' : 'ki-eye' }}"></i>
        </button>
    </form>
</div>
