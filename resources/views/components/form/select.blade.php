@props([
    'name',
    'options'     => [],
    'selected'    => null,
    'placeholder' => null,
    'label'       => null,
    'hint'        => null,
    'disabled'    => false,
    'required'    => false,
    'multiple'    => false,
    'leadingIcon' => null,
    'class'       => '',
])

@php
    $hasError  = $errors->has($name);
    $errorMsg  = $hasError ? $errors->first($name) : null;
    $inputId   = 'select_' . str_replace(['.', '[', ']'], '_', $name);
    $oldValue  = old($name, $selected);
    $fieldName = $multiple ? $name . '[]' : $name;

    $renderOptions = function() use ($placeholder, $options, $oldValue) {
        $html = '';
        if ($placeholder) {
            $html .= '<option value="">' . e($placeholder) . '</option>';
        }

        foreach ($options as $optValue => $optLabel) {
            if (is_array($optLabel)) {
                $html .= '<optgroup label="' . e($optValue) . '">';
                foreach ($optLabel as $groupValue => $groupLabel) {
                    $sel = (string)$groupValue === (string)$oldValue ? ' selected' : '';
                    $html .= '<option value="' . e($groupValue) . '"' . $sel . '>' . e($groupLabel) . '</option>';
                }
                $html .= '</optgroup>';
            } else {
                $sel = (is_array($oldValue)
                    ? in_array((string)$optValue, array_map('strval', $oldValue))
                    : (string)$optValue === (string)$oldValue) ? ' selected' : '';
                $html .= '<option value="' . e($optValue) . '"' . $sel . '>' . e($optLabel) . '</option>';
            }
        }
        return $html;
    };
@endphp

<div class="flex flex-col gap-1 {{ $class }}">
    @if($label)
        <label for="{{ $inputId }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    @if($leadingIcon)
        <div class="input {{ $hasError ? 'border-danger' : '' }}">
            <i class="{{ $leadingIcon }}"></i>
            <select
                id="{{ $inputId }}"
                name="{{ $fieldName }}"
                @if($disabled) disabled @endif
                @if($required) required @endif
                @if($multiple) multiple @endif
                class="select"
                {{ $attributes->except(['name', 'disabled', 'required', 'multiple', 'class']) }}
            >{!! $renderOptions() !!}{{ $slot ?? '' }}</select>
        </div>
    @else
        <select
            id="{{ $inputId }}"
            name="{{ $fieldName }}"
            @if($disabled) disabled @endif
            @if($required) required @endif
            @if($multiple) multiple @endif
            class="select {{ $hasError ? 'border-danger' : '' }}"
            {{ $attributes->except(['name', 'disabled', 'required', 'multiple', 'class']) }}
        >{!! $renderOptions() !!}{{ $slot ?? '' }}</select>
    @endif

    @if(!empty($errorMsg))
        <p class="text-danger text-xs mt-0.5">{{ $errorMsg }}</p>
    @elseif($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
