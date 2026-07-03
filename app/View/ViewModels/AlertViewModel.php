<?php

namespace App\View\ViewModels;

use App\Enums\AlertMessageTypeEnum;
use App\View\ViewModels\Contracts\RenderModelInterface;
use Illuminate\View\View;

class AlertViewModel implements RenderModelInterface
{
    public function __construct(
        public AlertMessageTypeEnum $type,
        public string $message = '',
        public string $title = '',
    ){
    }

    public function render(): View
    {
        return view('components.alert.alert-render', ['options' => $this]);
    }
}
