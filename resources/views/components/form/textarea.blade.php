@props([
    'name',
    'value'       => null,
    'placeholder' => null,
    'label'       => null,
    'hint'        => null,
    'rows'        => 4,
    'resize'      => 'y',
    'maxlength'   => null,
    'disabled'    => false,
    'readonly'    => false,
    'required'    => false,
    'class'       => '',
])

@php
    $hasError   = $errors->has($name);
    $errorMsg   = $hasError ? $errors->first($name) : null;
    $inputId    = 'textarea_' . str_replace(['.', '[', ']'], '_', $name);
    $oldValue   = old($name, $value);
    $resizeClass = match($resize) {
        'none' => 'resize-none',
        'x'    => 'resize-x',
        'both' => 'resize',
        default => 'resize-y',
    };
    $charCount = $maxlength ? mb_strlen($oldValue ?? '') : null;
@endphp

<div class="flex flex-col gap-1 {{ $class }}">
    @if($label)
        <div class="flex items-center justify-between">
            <label for="{{ $inputId }}" class="form-label mb-0">
                {{ $label }}
                @if($required) <span class="text-danger">*</span> @endif
            </label>
            @if($maxlength)
                <span class="text-xs text-gray-400" id="{{ $inputId }}_counter">
                    {{ $charCount }}/{{ $maxlength }}
                </span>
            @endif
        </div>
    @endif

    <textarea
        id="{{ $inputId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($required) required @endif
        class="textarea p-3 w-full {{ $resizeClass }} {{ $hasError ? 'border-danger' : '' }}"
        @if($maxlength)
            oninput="document.getElementById('{{ $inputId }}_counter').textContent = this.value.length + '/{{ $maxlength }}'"
        @endif
        {{ $attributes->except(['name', 'value', 'placeholder', 'disabled', 'readonly', 'required', 'rows', 'resize', 'maxlength', 'class']) }}
    >{{ $oldValue }}</textarea>

    @if($errorMsg)
        <p class="text-danger text-xs mt-0.5">{{ $errorMsg }}</p>
    @elseif($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
