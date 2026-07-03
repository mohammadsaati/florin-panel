@props([
    'title' => null,
    'icon' => null,
    'iconColor' => 'primary',
])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title)
        <div class="card-header">
            @if($icon)
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-{{ $iconColor }}-light shrink-0">
                    <i class="{{ $icon }} text-xl text-{{ $iconColor }}"></i>
                </div>
            @endif

            <h3 class="card-title flex-1 text-right">
                {{ $title }}
            </h3>
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
