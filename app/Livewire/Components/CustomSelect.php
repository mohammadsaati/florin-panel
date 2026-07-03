<?php

namespace App\Livewire\Components;

use App\Contracts\SelectDataSource;
use App\DTO\SelectFilter;
use App\DTO\SelectOption;
use App\DTO\SelectQuery;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CustomSelect extends Component
{
    // ── Data source ───────────────────────────────────────────────────────────
    // Class name (string) of a SelectDataSource implementation.
    // Stored as string so Livewire can serialize it between requests.
    public string $dataSource = '';
    public int    $perPage    = 15;

    // Filters serialized as plain arrays (built from SelectFilter DTOs in mount)
    // Shape per item: ['column' => string, 'operator' => string, 'value' => mixed]
    public array $filters = [];

    // ── Static options (for small in-memory lists — skip dataSource) ──────────
    public array $options = [];

    // ── Pagination state ──────────────────────────────────────────────────────
    public int   $page        = 1;
    public bool  $hasMore     = false;
    public array $loadedOptions = [];   // [['value' => string, 'label' => string], ...]

    // ── Selected state ────────────────────────────────────────────────────────
    // selected       : string[]   — the values
    // selectedItems  : array<string, string>  — value => label (survives pagination)
    public array $selected      = [];
    public array $selectedItems = [];

    // ── Behaviour props ───────────────────────────────────────────────────────
    public bool   $isMultiple   = false;
    public string $placeholder  = 'Select an option...';
    public bool   $searchable   = true;
    public bool   $disabled     = false;
    public string $size         = 'md';   // sm | md | lg | xl
    public ?int   $maxSelect    = null;
    public string $emitEvent    = 'selectChanged';
    public string $name         = 'select';
    public bool   $closeOnSelect = false;
    public bool   $clearable    = true;
    public string $searchQuery  = '';
    public bool   $isOpen       = false;

    // ─────────────────────────────────────────────────────────────────────────

    /**
     * @param SelectFilter[]  $filters
     * @param SelectOption[]  $selectedOptions  Pre-selected items WITH labels (so component
     *                                          doesn't need to re-fetch them on first render).
     */
    public function mount(
        string  $dataSource     = '',
        array   $options        = [],
        array   $selected       = [],
        array   $selectedOptions = [],   // [['value' => '1', 'label' => 'Alice'], ...]
        bool    $isMultiple     = false,
        string  $placeholder    = 'Select an option...',
        bool    $searchable     = true,
        bool    $disabled       = false,
        string  $size           = 'md',
        ?int    $maxSelect      = null,
        string  $emitEvent      = 'selectChanged',
        string  $name           = 'select',
        bool    $closeOnSelect  = false,
        bool    $clearable      = true,
        array   $filters        = [],   // SelectFilter[]
        int     $perPage        = 15,
    ): void {
        $this->dataSource    = $dataSource;
        $this->options       = $options;
        $this->isMultiple    = $isMultiple;
        $this->placeholder   = $placeholder;
        $this->searchable    = $searchable;
        $this->disabled      = $disabled;
        $this->size          = $size;
        $this->maxSelect     = $maxSelect;
        $this->emitEvent     = $emitEvent;
        $this->name          = $name;
        $this->closeOnSelect = $closeOnSelect;
        $this->clearable     = $clearable;
        $this->perPage       = $perPage;

        // Serialize SelectFilter objects → plain arrays (Livewire can't store objects)
        $this->filters = array_map(
            fn ($f) => $f instanceof SelectFilter ? $f->toArray() : $f,
            $filters,
        );

        // Bootstrap selected state
        $this->selected = array_map('strval', $selected);

        // Pre-load labels: caller passes selectedOptions so we don't need a round-trip
        foreach ($selectedOptions as $opt) {
            $o = $opt instanceof SelectOption ? $opt : SelectOption::fromArray($opt);
            $this->selectedItems[$o->value] = $o->label;
        }

        // For static options, build selectedItems from the options array
        if ($this->dataSource === '' && !empty($this->options)) {
            $map = collect($this->options)->keyBy('value');
            foreach ($this->selected as $v) {
                $this->selectedItems[$v] ??= $map->get($v)['label'] ?? $v;
            }
        }

        if ($this->dataSource !== '') {
            $this->fetchPage(reset: true);
        }
    }

    // ── Dropdown control ──────────────────────────────────────────────────────

    public function toggleDropdown(): void
    {
        if ($this->disabled) {
            return;
        }
        $this->isOpen = ! $this->isOpen;
    }

    public function closeDropdown(): void
    {
        $this->isOpen      = false;
        $this->searchQuery = '';

        if ($this->dataSource !== '') {
            $this->fetchPage(reset: true);
        }
    }

    // ── Selection ─────────────────────────────────────────────────────────────

    public function selectOption(string $value): void
    {
        if ($this->isMultiple) {
            if (in_array($value, $this->selected)) {
                return;
            }
            if ($this->maxSelect !== null && count($this->selected) >= $this->maxSelect) {
                return;
            }
            $this->selected[] = $value;

            if ($this->closeOnSelect) {
                $this->closeDropdown();
            }
        } else {
            $this->selected = [$value];
            $this->closeDropdown();
        }

        // Persist label so it survives pagination scroll
        $pool  = $this->dataSource !== '' ? $this->loadedOptions : $this->options;
        $found = collect($pool)->first(fn ($o) => (string) $o['value'] === $value);
        if ($found) {
            $this->selectedItems[$value] = $found['label'];
        }

        $this->dispatchChangeEvent();
    }

    public function deselectOption(string $value): void
    {
        $this->selected = array_values(array_filter($this->selected, fn ($v) => $v !== $value));
        unset($this->selectedItems[$value]);
        $this->dispatchChangeEvent();
    }

    public function clearAll(): void
    {
        $this->selected      = [];
        $this->selectedItems = [];
        $this->dispatchChangeEvent();
    }

    // ── Search ────────────────────────────────────────────────────────────────

    public function updatedSearchQuery(): void
    {
        if ($this->dataSource !== '') {
            $this->fetchPage(reset: true);
        }
    }

    // ── Pagination ────────────────────────────────────────────────────────────

    public function loadMore(): void
    {
        if (! $this->hasMore || $this->dataSource === '') {
            return;
        }
        $this->page++;
        $this->fetchPage();
    }

    private function fetchPage(bool $reset = false): void
    {
        if ($reset) {
            $this->page          = 1;
            $this->loadedOptions = [];
        }

        /** @var SelectDataSource $source */
        $source = app($this->dataSource);

        $result = $source(new SelectQuery(
            search:  $this->searchQuery,
            page:    $this->page,
            perPage: $this->perPage,
            filters: array_map(fn ($f) => SelectFilter::fromArray($f), $this->filters),
        ));

        $batch = $result->toArray();   // [['value' => string, 'label' => string], ...]

        $this->loadedOptions = $reset
            ? $batch
            : array_merge($this->loadedOptions, $batch);

        $this->hasMore = $result->hasMore;
    }

    // ── Computed ──────────────────────────────────────────────────────────────

    #[Computed]
    public function filteredOptions(): array
    {
        if ($this->dataSource !== '') {
            return $this->loadedOptions;
        }

        if ($this->searchQuery === '') {
            return $this->options;
        }

        $q = mb_strtolower($this->searchQuery);

        return array_values(array_filter(
            $this->options,
            fn ($o) => str_contains(mb_strtolower($o['label']), $q),
        ));
    }

    /** @return string[] */
    #[Computed]
    public function selectedLabels(): array
    {
        return array_map(fn ($v) => $this->selectedItems[$v] ?? $v, $this->selected);
    }

    public function isSelected(string $value): bool
    {
        return in_array($value, $this->selected);
    }

    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Event payload shape (both browser event and Livewire event):
     *
     *   name            : string    — the component's name prop
     *   selected        : string[]  — selected values
     *   selectedOptions : array     — [['value' => string, 'label' => string], ...]
     */
    private function dispatchChangeEvent(): void
    {
        $selectedOptions = array_map(
            fn ($v) => ['value' => $v, 'label' => $this->selectedItems[$v] ?? $v],
            $this->selected,
        );

        $payload = [
            'name'            => $this->name,
            'selected'        => $this->selected,
            'selectedOptions' => $selectedOptions,
        ];

        $this->dispatch('selectChanged', ...$payload);

        if ($this->emitEvent !== 'selectChanged') {
            $this->dispatch($this->emitEvent, ...$payload);
        }
    }

    public function render()
    {
        return view('livewire.components.custom-select');
    }
}
