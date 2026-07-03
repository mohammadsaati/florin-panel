<?php

namespace App\View\ViewModels\Contracts;

use Illuminate\View\View;

interface RenderModelInterface
{
    public function render(): View;
}
