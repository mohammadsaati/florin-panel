{{--
    Rendered server-side for each row by DataTableResponse.
    Receives:  $row — the User model instance.
--}}
<div class="flex items-center justify-end gap-1.5">

    <a href="{{ route($routePrefix . '.users.edit', $row->id) }}"
       class="btn btn-sm btn-icon btn-primary"
       title="Edit">
        <i class="ki-filled ki-pencil"></i>
    </a>

    <form
        action="{{ route($routePrefix . '.users.destroy', $row->id) }}"
        method="POST"
        onsubmit="return confirm('Delete {{ addslashes($row->name) }}?')"
    >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-icon btn-danger" title="Delete">
            <i class="ki-filled ki-trash"></i>
        </button>
    </form>

</div>
