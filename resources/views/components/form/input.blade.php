@props([
    'name',
    'type'          => 'text',
    'value'         => null,
    'placeholder'   => null,
    'label'         => null,
    'hint'          => null,
    'disabled'      => false,
    'readonly'      => false,
    'required'      => false,
    'prefix'        => null,
    'suffix'        => null,
    'leadingIcon'   => null,
    'trailingIcon'  => null,
    'class'         => '',
])

@php
    $hasError  = $errors->has($name);
    $errorMsg  = $hasError ? $errors->first($name) : null;
    $inputId   = 'input_' . str_replace(['.', '[', ']'], '_', $name);
    $hasAddons = $prefix || $suffix || $leadingIcon || $trailingIcon;
@endphp

<div class="flex flex-col gap-1 {{ $class }}">
    @if($label)
        <label for="{{ $inputId }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <div class="input {{ $hasAddons ? 'flex items-center gap-2' : '' }} {{ $hasError ? 'border-danger' : '' }}">
        @if($leadingIcon)
            <i class="{{ $leadingIcon }} text-gray-400 shrink-0 text-base"></i>
        @elseif($prefix)
            <span class="text-gray-500 shrink-0 text-sm">{{ $prefix }}</span>
        @endif

        <input
            id="{{ $inputId }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
            class="grow bg-transparent outline-none w-full"
            {{ $attributes->except(['name', 'type', 'value', 'placeholder', 'disabled', 'readonly', 'required', 'class']) }}
        />

        @if($trailingIcon)
            <i class="{{ $trailingIcon }} text-gray-400 shrink-0 text-base"></i>
        @elseif($suffix)
            <span class="text-gray-500 shrink-0 text-sm">{{ $suffix }}</span>
        @endif
    </div>

    @if($errorMsg)
        <p class="text-danger text-xs mt-0.5">{{ $errorMsg }}</p>
    @elseif($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
