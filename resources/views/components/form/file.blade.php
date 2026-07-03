@props([
    'name',
    'label'    => null,
    'hint'     => null,
    'accept'   => null,
    'multiple' => false,
    'disabled' => false,
    'required' => false,
    'class'    => '',
])

@php
    $hasError  = $errors->has($name);
    $errorMsg  = $hasError ? $errors->first($name) : null;
    $inputId   = 'file_' . str_replace(['.', '[', ']'], '_', $name);
    $fieldName = $multiple ? $name . '[]' : $name;
@endphp

<div class="flex flex-col gap-1 {{ $class }}">
    @if($label)
        <label for="{{ $inputId }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <label
        for="{{ $inputId }}"
        class="flex flex-col items-center justify-center w-full border-2 border-dashed rounded-lg cursor-pointer
               border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600
               py-6 px-4 {{ $hasError ? 'border-danger' : '' }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
    >
        <div class="flex flex-col items-center gap-2 text-center">
            <i class="ki-filled ki-cloud-upload text-3xl text-gray-400"></i>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium text-primary">{{ __('Click to upload') }}</span>
                {{ __('or drag and drop') }}
            </p>
            @if($accept)
                <p class="form-hint">{{ $accept }}</p>
            @endif
        </div>

        <input
            id="{{ $inputId }}"
            type="file"
            name="{{ $fieldName }}"
            @if($accept) accept="{{ $accept }}" @endif
            @if($multiple) multiple @endif
            @if($disabled) disabled @endif
            @if($required) required @endif
            class="hidden"
            {{ $attributes->except(['name', 'accept', 'multiple', 'disabled', 'required', 'class']) }}
        />
    </label>

    @if($errorMsg)
        <p class="text-danger text-xs mt-0.5">{{ $errorMsg }}</p>
    @elseif($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
