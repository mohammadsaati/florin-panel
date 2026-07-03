@php
    $httpMethod = $method->value;
    $realMethod = in_array($httpMethod, ['GET', 'POST']) ? $httpMethod : 'POST';
    $gridClass  = match($cols) {
        2       => 'card-body grid grid-cols-1 md:grid-cols-2 gap-5',
        3       => 'card-body grid grid-cols-1 md:grid-cols-3 gap-5',
        default => 'card-body grid gap-5',
    };
@endphp

<form
    id="{{ $id }}"
    method="{{ $realMethod }}"
    action="{{ $action }}"
    @if($enctype) enctype="{{ $enctype }}" @endif
    data-card-form
>
    @csrf
    @if(! in_array($httpMethod, ['GET', 'POST']))
        @method($httpMethod)
    @endif

    <div class="card">
        <div class="card-header">
            @if($icon)
                <div class="flex mx-2 items-center justify-center w-10 h-10 rounded-xl bg-{{ $iconColor }}-light shrink-0">
                    <i class="{{ $icon }} text-xl text-{{ $iconColor }}"></i>
                </div>
            @endif
            <h3 class="card-title flex-1 text-right">{{ $title }}</h3>
        </div>

        <div class="{{ $gridClass }}">
            {{ $slot }}
        </div>

        @if($submit || $cancel)
            <div class="card-footer flex justify-end items-center gap-2.5">
                @if($submit)
                    <button
                        type="submit"
                        class="btn btn-{{ $submit->type }} inline-flex items-center gap-2"
                        @if($submit->disabled) disabled @endif
                        data-card-form-submit
                    >
                        {{ $submit->title }}
                        <span data-card-form-spinner class="hidden inline-block h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"></span>
                    </button>
                @endif
                @if($cancel)
                    <a
                        class="btn btn-{{ $cancel->type }}"
                        href="{{ $cancel->disabled ? '#' : $cancel->to }}"
                        @if($cancel->disabled) aria-disabled="true" @endif
                    >
                        {{ $cancel->title }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</form>
