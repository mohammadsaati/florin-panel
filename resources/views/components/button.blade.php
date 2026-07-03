@props([
    'type'     => 'button',
    'variant'  => 'primary',
    'size'     => 'md',
    'disabled' => false,
    'href'     => null,
    'loading'  => false,
    'icon'     => null,
    'class'    => '',
])

@php
    $sizeClass = match($size) {
        'sm'  => 'btn-sm',
        'lg'  => 'btn-lg',
        default => '',
    };
    $baseClass = trim("btn btn-{$variant} {$sizeClass} inline-flex items-center gap-2 {$class}");
@endphp

@if($href)
    <a
        href="{{ $disabled ? '#' : $href }}"
        class="{{ $baseClass }} {{ $disabled ? 'opacity-50 pointer-events-none' : '' }}"
        {{ $attributes->except(['class', 'href']) }}
    >
        @if($icon) <i class="{{ $icon }}"></i> @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        class="{{ $baseClass }}"
        @if($disabled || $loading) disabled @endif
        {{ $attributes->except(['class', 'type']) }}
    >
        @if($icon && ! $loading) <i class="{{ $icon }}"></i> @endif
        @if($loading)
            <span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"></span>
        @endif
        {{ $slot }}
    </button>
@endif
