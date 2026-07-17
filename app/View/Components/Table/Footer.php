<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * @param Paginator<int, mixed>|array<int, mixed> $paginator
     */
    public function __construct(
        public Paginator|array $paginator,
        public array $perPageOptions = [10, 20, 50, 100, 300, 500],
        public int $perPage = 10,
        public readonly string $perPageWireModel = 'perPage',
    ) {
    }

    public function hasPagination(): bool
    {
        return $this->paginator instanceof Paginator;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.footer', [
            'hasPagination' => $this->hasPagination(),
        ]);
    }
}
