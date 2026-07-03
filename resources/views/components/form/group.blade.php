@props([
    'label'    => null,
    'for'      => null,
    'hint'     => null,
    'error'    => null,
    'required' => false,
    'cols'     => null,
    'class'    => '',
])

@php
    $colsClass = match((int) $cols) {
        2       => 'grid grid-cols-1 sm:grid-cols-2 gap-4',
        3       => 'grid grid-cols-1 sm:grid-cols-3 gap-4',
        4       => 'grid grid-cols-2 sm:grid-cols-4 gap-4',
        default => 'flex flex-col gap-1',
    };
@endphp

<div class="{{ $cols ? '' : 'flex flex-col gap-1' }} {{ $class }}">
    @if($label)
        <label
            @if($for) for="{{ $for }}" @endif
            class="form-label"
        >
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    @if($cols)
        <div class="{{ $colsClass }}">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif

    @if($error)
        <p class="text-danger text-xs mt-0.5">{{ $error }}</p>
    @elseif($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
