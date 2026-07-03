@props([
    'name',
    'value'       => '1',
    'label'       => null,
    'description' => null,
    'checked'     => false,
    'disabled'    => false,
    'hint'        => null,
    'class'       => '',
])

@php
    $inputId   = 'checkbox_' . str_replace(['.', '[', ']'], '_', $name) . '_' . $value;
    $isChecked = old($name, $checked);
@endphp

<div class="flex flex-col gap-1 {{ $class }}">
    <label class="flex items-start gap-2.5 cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
        <input
            type="checkbox"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($isChecked) checked @endif
            @if($disabled) disabled @endif
            class="checkbox mt-0.5 shrink-0"
            {{ $attributes->except(['name', 'value', 'checked', 'disabled', 'class']) }}
        />
        @if($label || $description)
            <div class="flex flex-col gap-0.5">
                @if($label)
                    <span class="text-gray-700 text-sm font-medium leading-tight">{{ $label }}</span>
                @endif
                @if($description)
                    <span class="text-gray-500 text-xs leading-snug">{{ $description }}</span>
                @endif
            </div>
        @endif
    </label>

    @if($hint)
        <p class="form-hint ms-6">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="text-danger text-xs mt-0.5">{{ $message }}</p>
    @enderror
</div>