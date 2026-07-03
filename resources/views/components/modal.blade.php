@props([
    'id',
    'title'  => null,
    'size'   => 'md',
    'static' => false,
])

@php
    $maxWidth = match($size) {
        'sm'  => 'max-w-sm',
        'lg'  => 'max-w-2xl',
        'xl'  => 'max-w-4xl',
        'full'=> 'max-w-full',
        default => 'max-w-lg',
    };
@endphp

<div
    class="modal"
    id="{{ $id }}"
    @if($static) data-modal-backdrop="static" @endif
>
    <div class="modal-backdrop" data-modal-dismiss="{{ $id }}"></div>

    <div class="modal-content {{ $maxWidth }} w-full">
        @if($title || isset($header))
            <div class="modal-header">
                @if(isset($header))
                    {{ $header }}
                @else
                    <h3 class="modal-title">{{ $title }}</h3>
                @endif
                <button
                    type="button"
                    class="btn btn-sm btn-icon btn-light shrink-0"
                    data-modal-dismiss="{{ $id }}"
                >
                    <i class="ki-filled ki-cross"></i>
                </button>
            </div>
        @endif

        <div class="modal-body">
            {{ $slot }}
        </div>

        @if(isset($footer))
            <div class="flex items-center justify-end gap-2.5 border-t border-gray-200 px-5 py-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
