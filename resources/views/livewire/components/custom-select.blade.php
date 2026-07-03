{{--
    Static (small list):
        <livewire:components.custom-select :options="[['value'=>'1','label'=>'One']]" name="cat" />

    Model-based paginated (large datasets):
        <livewire:components.custom-select
            model="App\Models\Category"
            label-key="name"
            value-key="id"
            :per-page="20"
            name="category_id"
        />

    Multi + paginated:
        <livewire:components.custom-select
            model="App\Models\Tag"
            :is-multiple="true"
            :max-select="5"
            size="lg"
            name="tags"
        />
--}}

@php
    $sizeClasses = match($size) {
        'sm'    => 'text-xs py-1 px-2',
        'lg'    => 'text-base py-2.5 px-4',
        'xl'    => 'text-lg py-3 px-5',
        default => 'text-sm py-2 px-3',
    };

    $chipClasses = match($size) {
        'sm'    => 'text-xs px-1.5 py-0.5',
        'lg'    => 'text-sm px-2 py-1',
        'xl'    => 'text-sm px-2.5 py-1',
        default => 'text-xs px-2 py-0.5',
    };

    $isMaxReached = $maxSelect !== null && count($selected) >= $maxSelect;
@endphp

<div
    wire:key="custom-select-{{ $name }}"
    x-data="{
        open: false,
        loadingMore: false,
        onScroll(el) {
            if (this.loadingMore) return;
            if (el.scrollTop + el.clientHeight >= el.scrollHeight - 60) {
                this.loadingMore = true;
                $wire.loadMore().then(() => { this.loadingMore = false });
            }
        }
    }"
    @keydown.escape.window="open = false; $wire.closeDropdown()"
    @click.away="open = false; $wire.closeDropdown()"
    class="relative w-full"
>
    {{-- Hidden inputs for form submission --}}
    @foreach($selected as $val)
        <input type="hidden" name="{{ $isMultiple ? $name.'[]' : $name }}" value="{{ $val }}">
    @endforeach

    {{-- Trigger button --}}
    <button
        type="button"
        @click="if (!{{ $disabled ? 'true' : 'false' }}) { open = !open; $wire.toggleDropdown(); $nextTick(() => { if (open) $refs.searchInput?.focus() }) }"
        class="w-full flex items-center flex-wrap gap-1.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition {{ $sizeClasses }} {{ $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer' }}"
        {{ $disabled ? 'disabled' : '' }}
        aria-haspopup="listbox"
        :aria-expanded="open"
    >
        <span class="flex-1 flex items-center flex-wrap gap-1.5 min-w-0">
            @if($isMultiple)
                @if(count($selected) > 0)
                    @foreach($selected as $idx => $val)
                        <span class="inline-flex items-center gap-0.5 bg-indigo-100 dark:bg-indigo-800/60 text-indigo-700 dark:text-indigo-300 rounded {{ $chipClasses }}">
                            <span>{{ $this->selectedLabels[$idx] ?? $val }}</span>
                            <button
                                type="button"
                                wire:click.stop="deselectOption('{{ $val }}')"
                                class="ml-0.5 hover:text-indigo-900 dark:hover:text-indigo-100 transition"
                                aria-label="Remove"
                            >
                                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                @else
                    <span class="text-gray-400 dark:text-gray-500">{{ $placeholder }}</span>
                @endif
            @else
                @if(count($selected) > 0)
                    <span class="truncate">{{ $this->selectedLabels[0] ?? $selected[0] }}</span>
                @else
                    <span class="text-gray-400 dark:text-gray-500">{{ $placeholder }}</span>
                @endif
            @endif
        </span>

        <span class="ml-auto flex items-center gap-1 shrink-0 pl-1">
            @if($clearable && count($selected) > 0)
                <span
                    wire:click.stop="clearAll"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition cursor-pointer"
                    title="Clear"
                >
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </span>
            @endif

            <svg
                class="w-4 h-4 text-gray-400 transition-transform duration-200"
                :class="open ? 'rotate-180' : ''"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </span>
    </button>

    {{-- Dropdown panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg ring-1 ring-black/5 overflow-hidden"
    >
        {{-- Search input --}}
        @if($searchable)
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="searchQuery"
                    x-ref="searchInput"
                    placeholder="Search..."
                    class="w-full pl-9 pr-3 py-2 text-sm border-b border-gray-200 dark:border-gray-700 bg-transparent text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none"
                >
                {{-- Search loading indicator --}}
                <span
                    wire:loading.flex
                    wire:target="updatedSearchQuery"
                    class="absolute inset-y-0 right-3 items-center"
                >
                    <svg class="w-4 h-4 animate-spin text-indigo-500" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                </span>
            </div>
        @endif

        {{-- Options list with infinite scroll --}}
        <ul
            role="listbox"
            class="max-h-56 overflow-y-auto py-1"
            @scroll.passive="onScroll($event.target)"
        >
            @forelse($this->filteredOptions as $option)
                @php
                    $optVal        = (string) $option['value'];
                    $isSelected    = $this->isSelected($optVal);
                    $isDisabledOpt = ! $isSelected && $isMaxReached;
                @endphp
                <li
                    role="option"
                    aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                    wire:click="{{ $isDisabledOpt ? '' : "selectOption('{$optVal}')" }}"
                    class="flex items-center gap-2 px-3 py-2 text-sm cursor-pointer select-none
                        {{ $isSelected
                            ? 'bg-indigo-100 dark:bg-indigo-800/50 text-indigo-700 dark:text-indigo-300 font-medium'
                            : 'text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}
                        {{ $isDisabledOpt ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}"
                >
                    @if($isMultiple)
                        <span class="flex-shrink-0 w-4 h-4 rounded-sm border-2 flex items-center justify-center transition
                            {{ $isSelected
                                ? 'bg-indigo-600 border-indigo-600'
                                : 'border-gray-400 dark:border-gray-500 bg-white dark:bg-gray-700' }}"
                        >
                            @if($isSelected)
                                <svg class="w-3 h-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </span>
                    @endif

                    <span class="flex-1 truncate">{{ $option['label'] }}</span>

                    @if(! $isMultiple && $isSelected)
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </li>
            @empty
                <li class="flex flex-col items-center justify-center gap-2 py-8 text-sm text-gray-400 dark:text-gray-500">
                    <svg class="w-6 h-6 opacity-50" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    No results found
                </li>
            @endforelse

            {{-- Load more spinner --}}
            @if($hasMore)
                <li
                    wire:loading.class.remove="hidden"
                    wire:loading.flex
                    wire:target="loadMore"
                    class="hidden items-center justify-center gap-2 py-3 text-xs text-gray-400 dark:text-gray-500"
                >
                    <svg class="w-4 h-4 animate-spin text-indigo-500" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Loading more...
                </li>
            @endif
        </ul>
    </div>
</div>
