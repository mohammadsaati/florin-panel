<?php

namespace App\Livewire\Admin\Tables;

use App\DTO\filter\UserFilterData;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $referralCode = '';

    #[Url(history: true)]
    public string $user_id = '';

    #[Url(history: true)]
    public string $invited_by = '';

    public array $perPageOptions = [10, 15, 25, 50, 100];
    public int $perPage = 15;

    private UserServiceInterface $userService;

    public function boot(UserServiceInterface $service): void
    {
        $this->userService = $service;
    }

    public function render(): View
    {
        return view('livewire.admin.tables.user-table', [
            'users' => $this->userService->filter(new UserFilterData(
                search: $this->search,
                referralCode: $this->referralCode,
                user_id: (int)$this->user_id,
                invited_by: $this->invited_by,
                page: (int)$this->getPage() ?? 1,
                per_page: $this->perPage,
            ))
        ]);
    }
}
