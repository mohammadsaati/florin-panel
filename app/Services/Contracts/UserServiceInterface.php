<?php

namespace App\Services\Contracts;

use App\DTO\filter\UserFilterData;
use App\DTO\user\CreateData;
use App\Models\User;
use Illuminate\Pagination\Paginator;

interface UserServiceInterface
{
    /** @return Paginator<int, User> */
    public function filter(UserFilterData $filter): Paginator;

    public function create(CreateData $data): User;

    public function generateReferralCode(): string;
}
