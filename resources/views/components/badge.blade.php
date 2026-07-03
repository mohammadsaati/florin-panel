@props([
    'variant' => 'default',
    'size'    => 'md',
    'pill'    => false,
    'dot'     => false,
    'outline' => false,
    'class'   => '',
])

@php
    $variantClass = $variant !== 'default' ? "badge-{$variant}" : '';
    $outlineClass = $outline ? 'badge-outline' : '';
    $sizeClass    = match($size) {
        'xs' => 'badge-xs',
        'sm' => 'badge-sm',
        'lg' => 'badge-lg',
        default => '',
    };
    $pillClass = $pill ? 'badge-pill' : '';
@endphp

<span
    class="{{ trim("badge {$variantClass} {$outlineClass} {$sizeClass} {$pillClass} {$class}") }}"
    {{ $attributes->except('class') }}
>
    @if($dot)
        <span class="badge-dot w-1.5 h-1.5 rounded-full inline-block me-1"></span>
    @endif
    {{ $slot }}
</span>
