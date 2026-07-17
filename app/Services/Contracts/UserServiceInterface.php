<?php

namespace App\Services\Contracts;

use App\DTO\filter\UserFilterData;
use App\DTO\user\CreateData;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /** @return Paginator<int, User> */
    public function filter(UserFilterData $filter): Paginator;

    public function create(CreateData $data): User;

    public function generateReferralCode(): string;

    public function checkUsersBirthday(): void;

    /**
     * @return Collection<int, User>
     */
    public function getTodayBirthdays(): Collection;

    /**
     * @param int[] $ids
     * @return Collection<int, User>
     */
    public function getByIds(array $ids): Collection;

    /**
     * @param int[] $userIds
     */
    public function sendBirthdaySmsWithUserIds(array $userIds): void;
}
