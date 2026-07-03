@props([
    'name',
    'options'  => [],
    'selected' => null,
    'label'    => null,
    'disabled' => false,
    'inline'   => false,
    'card'     => false,
    'hint'     => null,
    'class'    => '',
])

@php
    $oldValue = old($name, $selected);
@endphp

<div class="flex flex-col gap-1 {{ $class }}">
    @if($label)
        <span class="form-label">{{ $label }}</span>
    @endif

    @if($card)
        <div class="grid grid-cols-1 sm:grid-cols-{{ min(count($options), 3) }} gap-3">
            @foreach($options as $optValue => $optLabel)
                @php
                    $radioId  = 'radio_' . str_replace(['.', '[', ']'], '_', $name) . '_' . $optValue;
                    $isChecked = (string) $oldValue === (string) $optValue;
                @endphp
                <label
                    for="{{ $radioId }}"
                    class="relative flex items-center gap-3 cursor-pointer rounded-lg border-2 px-4 py-3 transition-colors
                           {{ $isChecked ? 'border-primary bg-primary-light' : 'border-gray-200 bg-white hover:border-gray-300' }}
                           {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                >
                    <input
                        type="radio"
                        id="{{ $radioId }}"
                        name="{{ $name }}"
                        value="{{ $optValue }}"
                        @if($isChecked) checked @endif
                        @if($disabled) disabled @endif
                        class="radio shrink-0"
                    />
                    @if(is_array($optLabel))
                        <div class="flex flex-col gap-0.5">
                            <span class="text-sm font-medium text-gray-800">{{ $optLabel['label'] }}</span>
                            @if(isset($optLabel['description']))
                                <span class="text-xs text-gray-500">{{ $optLabel['description'] }}</span>
                            @endif
                        </div>
                    @else
                        <span class="text-sm font-medium text-gray-800">{{ $optLabel }}</span>
                    @endif
                </label>
            @endforeach
        </div>
    @else
        <div class="{{ $inline ? 'flex flex-wrap gap-4' : 'flex flex-col gap-2' }}">
            @foreach($options as $optValue => $optLabel)
                @php $radioId = 'radio_' . str_replace(['.', '[', ']'], '_', $name) . '_' . $optValue; @endphp
                <label class="flex items-center gap-2 cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <input
                        type="radio"
                        id="{{ $radioId }}"
                        name="{{ $name }}"
                        value="{{ $optValue }}"
                        @if((string) $oldValue === (string) $optValue) checked @endif
                        @if($disabled) disabled @endif
                        class="radio"
                    />
                    @if(is_array($optLabel))
                        <div class="flex flex-col gap-0.5">
                            <span class="radio-label">{{ $optLabel['label'] }}</span>
                            @if(isset($optLabel['description']))
                                <span class="text-xs text-gray-500">{{ $optLabel['description'] }}</span>
                            @endif
                        </div>
                    @else
                        <span class="radio-label">{{ $optLabel }}</span>
                    @endif
                </label>
            @endforeach
        </div>
    @endif

    @if($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="text-danger text-xs mt-0.5">{{ $message }}</p>
    @enderror
</div>
