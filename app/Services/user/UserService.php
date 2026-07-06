<?php

namespace App\Services\user;

use App\DTO\filter\UserFilterData;
use App\DTO\user\CreateData;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\UserNotFoundException;
use App\Jobs\SendBirthDaySmsJob;
use App\Jobs\SendWellcomSmsJob;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    public function filter(UserFilterData $filter): Paginator
    {
        return User::filter($filter);
    }

    public function create(CreateData $data): User
    {
        $user = User::createFromData($data);

        if ($data->address !== null) {
            UserAddress::createForUser($user->id, $data->address);
        }

        SendWellcomSmsJob::dispatch(
            $user->first_name,
            $user->referral_code,
            $user->mobile,
        );

        return $user;
    }

    public function generateReferralCode(): string
    {
        $code = 'florin-' . Str::random(6);
        if (User::checkReferralExists($code)) {
            $code = $this->generateReferralCode();
        }

        return $code;
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidPasswordException
     */
    public function login(string $phone, string $password): User
    {
        /**
         * @var User|null $user
         */
        $user = User::findByPhoneNumber($phone);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $check = Hash::check($password, $user->password);

        if (!$check) {
            throw new InvalidPasswordException();
        }

        return $user;
    }


    public function checkUsersBirthday(): void
    {
        User::checkTodayBirthDates(
                /**
                 * @param Collection<int, User> $users
                 */
            action: function (Collection $users) {
                $users->each(function (User $user) {
                   SendBirthDaySmsJob::dispatch($user->first_name, $user->mobile);
                });
            }
        );
    }
}
