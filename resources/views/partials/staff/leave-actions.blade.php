<div class="flex gap-1">
    <a href="{{ route($routePrefix . '.staff.leaves.edit', $row->id) }}" class="btn btn-xs btn-secondary">ویرایش</a>

    <form action="{{ route($routePrefix . '.staff.leaves.destroy', $row->id) }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('این مرخصی حذف شود؟')">حذف</button>
    </form>
</div>
