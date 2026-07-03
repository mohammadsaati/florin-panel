<?php

namespace App\View\Components\Card;

use App\DTO\form\SubmitBtnData;
use App\Enums\FormMethodEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action,
        public FormMethodEnum $method,
        public string $title,
        public string|null $id = null,
        public string|null $enctype = null,
        public SubmitBtnData|null $submit = null,
        public SubmitBtnData|null $cancel = null,
        public int $cols = 1,
        public string|null $icon = null,
        public string $iconColor = 'primary',
    ) {
        if (!$this->id) {
            $this->id = 'form_' . Str::uuid()->toString();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.form');
    }
}
