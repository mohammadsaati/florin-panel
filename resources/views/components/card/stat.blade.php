@props([
    'title',
    'value',
    'icon'    => null,
    'change'  => null,
    'trend'   => null,
    'prefix'  => null,
    'suffix'  => null,
    'color'   => 'primary',
    'class'   => '',
])

@php
    $trendColor = match($trend) {
        'up'   => 'text-success',
        'down' => 'text-danger',
        default => 'text-gray-500',
    };
    $trendIcon = match($trend) {
        'up'   => 'ki-filled ki-arrow-up',
        'down' => 'ki-filled ki-arrow-down',
        default => null,
    };
@endphp

<div class="card {{ $class }}">
    <div class="card-body flex items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900">
                @if($prefix) <span class="text-lg font-medium text-gray-400">{{ $prefix }}</span> @endif
                {{ $value }}
                @if($suffix) <span class="text-lg font-medium text-gray-400">{{ $suffix }}</span> @endif
            </p>
            @if($change !== null)
                <p class="flex items-center gap-1 text-xs font-medium {{ $trendColor }}">
                    @if($trendIcon) <i class="{{ $trendIcon }}"></i> @endif
                    {{ $change }}
                </p>
            @endif
        </div>

        @if($icon)
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-{{ $color }}-light shrink-0">
                <i class="{{ $icon }} text-2xl text-{{ $color }}"></i>
            </div>
        @endif
    </div>
</div>
