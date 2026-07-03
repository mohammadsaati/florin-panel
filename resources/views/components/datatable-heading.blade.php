@props([
    'sortable' => false,
    'sort' => null,         // column key to sort by (calls wire:click="sort('<key>')")
    'sortBy' => null,       // current active sort column (from the Livewire component)
    'sortDir' => 'asc',     // current active sort direction
])

<th
    {{ $attributes->class([
        'px-5 py-3 text-xs font-semibold uppercase text-gray-500 whitespace-nowrap',
        'cursor-pointer select-none hover:text-gray-800' => $sortable && $sort,
    ]) }}
    @if($sortable && $sort) wire:click="sort('{{ $sort }}')" @endif
>
    <span class="flex items-center gap-1.5">
        {{ $slot }}
        @if($sortable && $sort)
            @if($sortBy === $sort)
                <i class="ki-filled {{ $sortDir === 'asc' ? 'ki-arrow-up' : 'ki-arrow-down' }} text-xs text-primary"></i>
            @else
                <i class="ki-filled ki-arrows-circle text-xs text-gray-300"></i>
            @endif
        @endif
    </span>
</th>
