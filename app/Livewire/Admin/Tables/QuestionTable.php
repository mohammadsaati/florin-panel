<?php

namespace App\Livewire\Admin\Tables;

use App\DTO\filter\QuestionFilter;
use App\Services\user\QuestionService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionTable extends Component
{
    use WithPagination;
    private QuestionService $service;

    public function boot(QuestionService $service): void
    {
        $this->service = $service;
    }


    public function render(): View
    {
        return view('livewire.admin.tables.question-table', [
            'questions' => $this->service->filter(new QuestionFilter(
                page: (int)$this->getPage() ?? 1,
                per_page: 50
            )),
        ]);
    }
}
