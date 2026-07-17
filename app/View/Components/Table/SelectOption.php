<?php

namespace App\View\Components\Table;

use Closure;
use BackedEnum;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectOption extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $name Input name
     * @param array<int|string, string>|class-string<BackedEnum> $options Enum class (uses cases + trans()) or [value => label] array
     * @param string $placeholder Placeholder option text
     * @param string|null $wireModel Livewire wire:model binding (e.g. "status")
     * @param string $size 'sm'|'md'|'lg'    Size variant (matches select2)
     * @param int|string|null $value Initial selected value (e.g. for Livewire pass :value="$status")
     */
    public function __construct(
        public readonly string $name,
        public readonly string|array $options,
        public readonly string $placeholder = 'انتخاب کنید',
        public readonly string|null $wireModel = null,
        public readonly bool $wireModelLive = false,
        public readonly bool $includeAll = false,
        public readonly string $allLabel = 'همه',
        public readonly string $size = 'sm',
        public readonly string $classes = '',
        public readonly string|int|null $value = null,
        public readonly string $form = '',
    ) {
    }

    /** Trigger div size classes (matches select2 toggle). */
    public function triggerSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'min-h-[32px] px-2 py-1',
            'lg' => 'min-h-[48px] px-3 py-2.5',
            default => 'min-h-[38px] px-2.5 py-1.5',
        };
    }

    /** Text size class for dropdown options (matches select2). */
    public function textSizeClass(): string
    {
        return match ($this->size) {
            'sm' => 'text-xs',
            'lg' => 'text-base',
            default => 'text-sm',
        };
    }

    /**
     * @return array<int, array{value: int|string, label: string}>
     */
    public function optionsList(): array
    {

        if (is_array($this->options)) {
            $list = array_map(
                fn (string|int $value) => ['value' => $value, 'label' => $value],
                $this->options
            );

            if ($this->includeAll) {
                array_unshift($list, ['value' => '', 'label' => $this->allLabel]);
            }

            return $list;
        }

        $cases = $this->options::cases();

        $list = array_map(
            fn (BackedEnum $case) => [
                'value' => $case->value,
                'label' => method_exists($case, 'trans') ? $case->trans() : $case->name,
            ],
            $cases,
        );

        if ($this->includeAll) {
            array_unshift($list, ['value' => '', 'label' => $this->allLabel]);
        }

        return $list;
    }

    public function render(): View|Closure|string
    {
        return view('components.table.select-option', [
            'name' => $this->name,
            'wireModel' => $this->wireModel,
            'wireModelLive' => $this->wireModelLive,
            'placeholder' => $this->placeholder,
            'classes' => $this->classes,
            'value' => $this->value,
            'form' => $this->form,
            'optionsList' => fn () => $this->optionsList(),
            'triggerSizeClasses' => fn () => $this->triggerSizeClasses(),
            'textSizeClass' => fn () => $this->textSizeClass(),
        ]);
    }
}
