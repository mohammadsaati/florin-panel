@php
    use App\Enums\AlertMessageTypeEnum;
@endphp

@props([
    'type'        => 'info',
    'title'       => null,
    'dismissible' => false,
    'icon'        => null,
    'class'       => '',
])

@php
    $config = match($type) {
        AlertMessageTypeEnum::SUCCESS->value => ['bg' => 'bg-success-light', 'border' => 'border-success', 'text' => 'text-success', 'icon' => 'ki-filled ki-check-circle'],
        AlertMessageTypeEnum::DANGER->value  => ['bg' => 'bg-danger-light',  'border' => 'border-danger',  'text' => 'text-danger',  'icon' => 'ki-filled ki-information-2'],
        AlertMessageTypeEnum::WARNING->value => ['bg' => 'bg-warning-light', 'border' => 'border-warning', 'text' => 'text-warning', 'icon' => 'ki-filled ki-warning-2'],
        default   => ['bg' => 'bg-info-light',    'border' => 'border-info',    'text' => 'text-info',    'icon' => 'ki-filled ki-information'],
    };
    $iconClass = $icon ?? $config['icon'];
@endphp

<div
    class="flex items-start gap-3 rounded-lg border px-4 py-3 {{ $config['bg'] }} {{ $config['border'] }} {{ $class }}"
    role="alert"
    {{ $attributes->except('class') }}
>
    <i class="{{ $iconClass }} text-xl {{ $config['text'] }} mt-0.5 shrink-0"></i>

    <div class="flex flex-col gap-0.5 grow">
        @if($title)
            <p class="font-semibold text-sm {{ $config['text'] }}">{{ $title }}</p>
        @endif
        <div class="text-sm text-gray-700">{{ $slot }}</div>
    </div>

    @if($dismissible)
        <button
            type="button"
            class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors"
            onclick="this.closest('[role=alert]').remove()"
        >
            <i class="ki-filled ki-cross text-xs"></i>
        </button>
    @endif
</div>
