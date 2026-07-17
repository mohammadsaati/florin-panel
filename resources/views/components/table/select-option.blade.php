@php
    $list = $optionsList();
    $optionsJson = \Illuminate\Support\Js::from($list);
    $initialValue = $value !== null ? (string) $value : '';
    $initialLabel = '';
    if ($initialValue !== '') {

        $found = collect($list)->first(fn ($o) => (string) $o['value'] === $initialValue);

        $initialLabel = $found ? $found['label'] : '';
    }

@endphp
<div
    class="relative {{ $classes }}"
    x-data="{
        optionsList: {{ $optionsJson }},
        wireModelName: @js($wireModel),
        selectedValue: @js($initialValue),
        selectedLabel: @js($initialLabel),
        isOpen: false,
        syncFromValue(val) {
            if (val !== null && val !== undefined && String(val) !== String(this.selectedValue)) {
                this.selectedValue = val;
                const o = this.optionsList.find(opt => String(opt.value) === String(val));
                this.selectedLabel = o ? o.label : '';
            }
        },
        init() {
            // Cloned rows keep the source's stale x-data literal; trust the hidden input value instead.
            const hidden = this.$refs.hidden;
            if (hidden && hidden.value !== '' && String(hidden.value) !== String(this.selectedValue)) {
                this.selectedValue = hidden.value;
                this.selectedLabel = '';
            }

            if (this.selectedValue && !this.selectedLabel) {
                const o = this.optionsList.find(opt => String(opt.value) === String(this.selectedValue));
                this.selectedLabel = o ? o.label : '';
            }

            if (this.wireModelName && typeof $wire !== 'undefined') {
                const wireVal = $wire.get(this.wireModelName);
                if (wireVal !== null && wireVal !== undefined) {
                    this.syncFromValue(wireVal);
                }

                $wire.$watch(this.wireModelName, (val) => {
                    this.syncFromValue(val);
                });
            }
        },
        select(option) {
            this.selectedValue = option.value;
            this.selectedLabel = option.label;
            const input = this.$refs.hidden;
            if (input) {
                input.value = option.value;
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }
            this.isOpen = false;
        },
        openAbove: false,
        close() { this.isOpen = false; },
        toggle() {
            if (!this.isOpen) {
                const dropdown = this.$refs.dropdown;
                if (dropdown) {
                    dropdown.style.visibility = 'hidden';
                    dropdown.style.display = 'block';
                    const dropdownHeight = dropdown.offsetHeight;
                    dropdown.style.display = '';
                    dropdown.style.visibility = '';

                    const triggerRect = this.$el.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - triggerRect.bottom;
                    this.openAbove = spaceBelow < dropdownHeight + 8;
                }
                this.isOpen = true;
            } else {
                this.isOpen = false;
            }
        }
    }"
    x-on:click.outside="close()"
    x-on:keydown.escape.window="close()"
    role="combobox"
    :aria-expanded="isOpen"
>
    <input
        type="hidden"
        name="{{ $name }}"
        x-ref="hidden"
        value="{{ $initialValue }}"
        @if($wireModel) wire:model{{ $wireModelLive ? '.live' : '' }}="{{ $wireModel }}" @endif
        @if($form) form="{{ $form }}" @endif
    >

    {{-- Toggle (styled like select2) --}}
    <div
        class="border border-gray-300 rounded cursor-pointer bg-light-active flex flex-wrap items-center gap-1.5 hover:border-gray-400 transition-colors {{ $triggerSizeClasses() }}"
        :class="isOpen ? 'border-primary shadow-[var(--tw-input-focus-box-shadow)]' : ''"
        x-on:click="toggle()"
        tabindex="0"
        x-on:keydown.enter.prevent="toggle()"
        x-on:keydown.space.prevent="toggle()"
        role="button"
    >
        <span class="flex-1 min-w-0 text-right truncate {{ $textSizeClass() }}"
              :class="selectedLabel ? 'text-gray-700' : 'text-gray-500'"
              x-text="selectedLabel || @js($placeholder)"
        ></span>

        <svg
            class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200"
            :class="{ 'rotate-180': isOpen }"
            fill="none" stroke="currentColor" viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    {{-- Dropdown panel (styled like select2) --}}
    <div
        x-ref="dropdown"
        x-cloak
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 w-full border border-gray-300 rounded-lg shadow shadow-xl bg-light-active overflow-hidden min-w-[7rem]"
        :class="openAbove ? 'bottom-full mb-1' : 'top-full mt-1'"
    >
        <ul class="max-h-60 overflow-y-auto py-1" role="listbox">
            @foreach($list as $option)
                <li
                    role="option"
                    tabindex="-1"
                    class="px-3 py-2 cursor-pointer transition-colors flex items-center gap-2 text-gray-700 hover:bg-primary-light {{ $textSizeClass() }}"
                    :class="String(selectedValue) === String(@js($option['value'])) ? 'bg-primary-light text-primary font-medium' : ''"
                    x-on:click="select({ value: @js($option['value']), label: @js($option['label']) })"
                >
                    <span class="truncate">{{ $option['label'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
