@props([
    'name' => 'tmp_name',
    'title' => '',
    'repeatItems' => ['name' => 'text'],
    'add_text' => 'افزودن',
    'class' => '',
])

{{ $title }}

@php
    $countItems = count($repeatItems);

    $col = match ($countItems) {
        2 => 'grid grid-cols-1 md:grid-cols-2 gap-5',
        3 => 'grid grid-cols-1 md:grid-cols-3 gap-5',
        default => 'grid gap-5',
    };
@endphp

<div class="repeat-wrapper flex flex-col gap-1 {{ $class }}">

    <div class="repeat-container flex flex-col gap-4">

        <div class="repeat-row flex items-start gap-3">
            <div class="{{ $col }} repeat-item flex-1">
                @foreach($repeatItems as $itemKey => $itemValue)
                    <input
                        id="{{ $name . '_1_' . $itemKey }}"
                        type="{{ $itemValue }}"
                        name="{{ $name . '[]' }}"
                        class="input grow bg-transparent outline-none w-full"
                    />
                @endforeach
            </div>

            <button type="button" class="btn btn-danger btn-outline btn-sm delete-row">
                <i class="ki-filled ki-trash"></i>
            </button>
        </div>

    </div>

    <div class="my-2">
        <button type="button" class="btn btn-outline btn-primary btn-sm add-repeat">
            <i class="ki-filled ki-plus"></i>
            {{ $add_text }}
        </button>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('click', function (e) {

            // Add row
            if (e.target.closest('.add-repeat')) {

                const wrapper = e.target.closest('.repeat-wrapper');
                const container = wrapper.querySelector('.repeat-container');
                const firstRow = container.querySelector('.repeat-row');

                const newRow = firstRow.cloneNode(true);

                const index = container.querySelectorAll('.repeat-row').length + 1;

                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';

                    input.id = input.id.replace(/_\d+_/, `_${index}_`);
                    input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                });

                container.appendChild(newRow);
            }

            // Delete row
            if (e.target.closest('.delete-row')) {

                const row = e.target.closest('.repeat-row');
                const container = row.parentElement;

                if (container.querySelectorAll('.repeat-row').length === 1) {
                    return;
                }

                row.remove();
            }

        });
    </script>
@endpush




